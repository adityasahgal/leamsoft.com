<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:category-create|category-edit|category-delete|category-publish', ['only' => ['index', 'store']]);
        $this->middleware('permission:category-create', ['only' => ['store']]);
        $this->middleware('permission:category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:category-delete', ['only' => ['destroy']]);
        $this->middleware('permission:category-publish', ['only' => ['status']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            $status = $request->status;
            $data = Category::with('users')
                ->withCount(['subcategories', 'services'])
                ->when(!empty($search), fn($q) => $q->where('name', 'LIKE', "%{$search}%"))
                ->when($status !== null && $status !== '', fn($q) => $q->where('status', $status))
                ->orderBy('sort_order')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('admin.category.dataTable', compact('data'))->render();
        }

        $data = Category::with('users')
            ->withCount(['subcategories', 'services'])
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.category.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name|max:255',
            'thumbnail_img' => 'nullable|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $cat = new Category();
            $cat->name = $request->name;
            $cat->slug = $this->makeSlug($request->slug ?: $request->name);
            $cat->icon = $request->icon;
            $cat->color = $request->color;
            $cat->short_description = $request->short_description;
            $cat->description = $request->description;
            $cat->meta_title = $request->meta_title;
            $cat->meta_description = $request->meta_description;
            $cat->keywords = $request->keywords;
            $cat->sort_order = (int) ($request->sort_order ?? 0);
            $cat->featured = $request->boolean('featured') ? 1 : 0;
            $cat->status = 1;
            $cat->uid = Auth::id();

            if ($request->hasFile('thumbnail_img')) {
                $cat->thumbnail_img = $request->file('thumbnail_img')->store('uploads/categories');
            }

            $cat->save();
            return redirect()->route('category.index')->with(['status' => 'success', 'message' => 'Category created successfully.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function edit(Request $request)
    {
        $row = Category::findOrFail($request->id);
        $thumb = (! empty($row->thumbnail_img) && file_exists('storage/' . $row->thumbnail_img))
            ? '<img src="' . url('storage/' . $row->thumbnail_img) . '" style="width:120px; height:auto; margin-top:6px; border-radius:4px;">'
            : '';
        echo '<div class="modal-header">
            <h4 class="modal-title">Update Category</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="' . route('category.update') . '" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                <input type="hidden" name="id" value="' . $row->id . '" />
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="' . e($row->name) . '" required>
                    </div>
                    <div class="form-group">
                        <label>Slug <small class="text-muted">(leave blank to regenerate from name)</small></label>
                        <input type="text" class="form-control" name="slug" value="' . e($row->slug) . '">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Icon <small class="text-muted">(emoji or icon class)</small></label>
                            <input type="text" class="form-control" name="icon" value="' . e($row->icon) . '">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Color</label>
                            <input type="text" class="form-control" name="color" value="' . e($row->color) . '">
                        </div>
                        <div class="form-group col-md-3">
                            <label>Sort Order</label>
                            <input type="number" class="form-control" name="sort_order" value="' . (int) $row->sort_order . '">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Thumbnail Image</label>
                        <input type="file" class="form-control-file" name="thumbnail_img" accept="image/*">
                        ' . $thumb . '
                    </div>
                    <div class="form-group">
                        <label>Short Description</label>
                        <textarea class="form-control" name="short_description" rows="2">' . e($row->short_description) . '</textarea>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" rows="4">' . e($row->description) . '</textarea>
                    </div>
                    <div class="form-group">
                        <label>Meta Title</label>
                        <input type="text" class="form-control" name="meta_title" value="' . e($row->meta_title) . '">
                    </div>
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="meta_description">' . e($row->meta_description) . '</textarea>
                    </div>
                    <div class="form-group">
                        <label>Keywords</label>
                        <textarea class="form-control" name="keywords">' . e($row->keywords) . '</textarea>
                    </div>
                    <div class="form-group">
                        <label><input type="checkbox" name="featured" value="1" ' . ($row->featured ? 'checked' : '') . '> Featured</label>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>';
    }

    public function update(Request $request)
    {
        $cat = Category::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|unique:categories,name,' . $cat->id,
            'thumbnail_img' => 'nullable|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $cat->name = $request->name;
            $cat->slug = $this->makeSlug($request->slug ?: $request->name, $cat->id);
            $cat->icon = $request->icon;
            $cat->color = $request->color;
            $cat->short_description = $request->short_description;
            $cat->description = $request->description;
            $cat->meta_title = $request->meta_title;
            $cat->meta_description = $request->meta_description;
            $cat->keywords = $request->keywords;
            $cat->sort_order = (int) ($request->sort_order ?? 0);
            $cat->featured = $request->boolean('featured') ? 1 : 0;
            $cat->uid = Auth::id();

            if ($request->hasFile('thumbnail_img')) {
                if (! empty($cat->thumbnail_img) && file_exists('storage/' . $cat->thumbnail_img)) {
                    @unlink('storage/' . $cat->thumbnail_img);
                }
                $cat->thumbnail_img = $request->file('thumbnail_img')->store('uploads/categories');
            }

            $cat->save();
            return redirect()->route('category.index')->with(['status' => 'success', 'message' => 'Category updated successfully.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function status(Request $request)
    {
        $cat = Category::find($request->id);
        if (! $cat) return response()->json(['status' => 'error']);

        if ($request->type == 'featured') {
            $cat->featured = $request->status;
        } else {
            $cat->status = $request->status;
        }
        $cat->uid = Auth::id();
        $cat->save();
        return response()->json(['status' => 'success']);
    }

    public function destroy(Request $request)
    {
        $cat = Category::find($request->id);
        if (! $cat) return response()->json(['status' => 'error', 'message' => 'Category not found.']);

        $subCount = Subcategory::where('category_id', $cat->id)->count();
        $svcCount = Service::where('category_id', $cat->id)->count();
        if ($subCount || $svcCount) {
            return response()->json(['status' => 'error', 'message' => "Cannot delete — {$subCount} subcategories and {$svcCount} services depend on this category."]);
        }

        if (! empty($cat->thumbnail_img) && file_exists('storage/' . $cat->thumbnail_img)) {
            @unlink('storage/' . $cat->thumbnail_img);
        }
        $cat->delete();
        return response()->json(['status' => 'success', 'message' => 'Category deleted.']);
    }

    private function makeSlug(string $value, $ignoreId = null): string
    {
        $base = Str::slug($value) ?: 'category';
        $slug = $base;
        $i = 1;
        while (
            Category::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . (++$i);
        }
        return $slug;
    }
}
