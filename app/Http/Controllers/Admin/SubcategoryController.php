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

class SubcategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:subcategory-create|subcategory-edit|subcategory-delete|subcategory-publish', ['only' => ['index', 'store']]);
        $this->middleware('permission:subcategory-create', ['only' => ['store']]);
        $this->middleware('permission:subcategory-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:subcategory-delete', ['only' => ['destroy']]);
        $this->middleware('permission:subcategory-publish', ['only' => ['status']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            $status = $request->status;
            $categoryId = $request->category_id;
            $data = Subcategory::with(['category', 'users'])
                ->withCount('services')
                ->when(!empty($search), fn($q) => $q->where('name', 'LIKE', "%{$search}%"))
                ->when($status !== null && $status !== '', fn($q) => $q->where('status', $status))
                ->when(!empty($categoryId), fn($q) => $q->where('category_id', $categoryId))
                ->orderBy('sort_order')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
            return view('admin.subcategory.dataTable', compact('data'))->render();
        }

        $data = Subcategory::with(['category', 'users'])
            ->withCount('services')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $categories = Category::where('status', 1)->orderBy('name')->get();
        return view('admin.subcategory.index', compact('data', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:255',
            'thumbnail_img' => 'nullable|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $sub = new Subcategory();
            $sub->category_id = $request->category_id;
            $sub->name = $request->name;
            $sub->slug = $this->makeSlug($request->slug ?: $request->name);
            $sub->icon = $request->icon;
            $sub->short_description = $request->short_description;
            $sub->description = $request->description;
            $sub->meta_title = $request->meta_title;
            $sub->meta_description = $request->meta_description;
            $sub->keywords = $request->keywords;
            $sub->sort_order = (int) ($request->sort_order ?? 0);
            $sub->status = 1;
            $sub->uid = Auth::id();

            if ($request->hasFile('thumbnail_img')) {
                $sub->thumbnail_img = $request->file('thumbnail_img')->store('uploads/subcategories');
            }

            $sub->save();
            return redirect()->route('subcategory.index')->with(['status' => 'success', 'message' => 'Subcategory created successfully.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function edit(Request $request)
    {
        $row = Subcategory::findOrFail($request->id);
        $categories = Category::where('status', 1)->orderBy('name')->get();

        $catOptions = '';
        foreach ($categories as $c) {
            $sel = ($c->id == $row->category_id) ? 'selected' : '';
            $catOptions .= '<option value="' . $c->id . '" ' . $sel . '>' . e($c->name) . '</option>';
        }

        $thumb = (! empty($row->thumbnail_img) && file_exists('storage/' . $row->thumbnail_img))
            ? '<img src="' . url('storage/' . $row->thumbnail_img) . '" style="width:120px; height:auto; margin-top:6px; border-radius:4px;">'
            : '';

        echo '<div class="modal-header">
            <h4 class="modal-title">Update Subcategory</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form action="' . route('subcategory.update') . '" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                <input type="hidden" name="id" value="' . $row->id . '" />
                <div class="card-body">
                    <div class="form-group">
                        <label>Parent Category</label>
                        <select class="form-control" name="category_id" required>' . $catOptions . '</select>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" value="' . e($row->name) . '" required>
                    </div>
                    <div class="form-group">
                        <label>Slug <small class="text-muted">(leave blank to regenerate from name)</small></label>
                        <input type="text" class="form-control" name="slug" value="' . e($row->slug) . '">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label>Icon <small class="text-muted">(emoji or icon class)</small></label>
                            <input type="text" class="form-control" name="icon" value="' . e($row->icon) . '">
                        </div>
                        <div class="form-group col-md-4">
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
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update Subcategory</button>
                </div>
            </form>
        </div>';
    }

    public function update(Request $request)
    {
        $sub = Subcategory::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:255',
            'thumbnail_img' => 'nullable|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $sub->category_id = $request->category_id;
            $sub->name = $request->name;
            $sub->slug = $this->makeSlug($request->slug ?: $request->name, $sub->id);
            $sub->icon = $request->icon;
            $sub->short_description = $request->short_description;
            $sub->description = $request->description;
            $sub->meta_title = $request->meta_title;
            $sub->meta_description = $request->meta_description;
            $sub->keywords = $request->keywords;
            $sub->sort_order = (int) ($request->sort_order ?? 0);
            $sub->uid = Auth::id();

            if ($request->hasFile('thumbnail_img')) {
                if (! empty($sub->thumbnail_img) && file_exists('storage/' . $sub->thumbnail_img)) {
                    @unlink('storage/' . $sub->thumbnail_img);
                }
                $sub->thumbnail_img = $request->file('thumbnail_img')->store('uploads/subcategories');
            }

            $sub->save();
            return redirect()->route('subcategory.index')->with(['status' => 'success', 'message' => 'Subcategory updated successfully.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function status(Request $request)
    {
        $sub = Subcategory::find($request->id);
        if (! $sub) return response()->json(['status' => 'error']);

        $sub->status = $request->status;
        $sub->uid = Auth::id();
        $sub->save();
        return response()->json(['status' => 'success']);
    }

    public function destroy(Request $request)
    {
        $sub = Subcategory::find($request->id);
        if (! $sub) return response()->json(['status' => 'error', 'message' => 'Subcategory not found.']);

        $svcCount = Service::where('subcategory_id', $sub->id)->count();
        if ($svcCount) {
            return response()->json(['status' => 'error', 'message' => "Cannot delete — {$svcCount} services depend on this subcategory."]);
        }

        if (! empty($sub->thumbnail_img) && file_exists('storage/' . $sub->thumbnail_img)) {
            @unlink('storage/' . $sub->thumbnail_img);
        }
        $sub->delete();
        return response()->json(['status' => 'success', 'message' => 'Subcategory deleted.']);
    }

    private function makeSlug(string $value, $ignoreId = null): string
    {
        $base = Str::slug($value) ?: 'subcategory';
        $slug = $base;
        $i = 1;
        while (
            Subcategory::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . (++$i);
        }
        return $slug;
    }
}
