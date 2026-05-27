<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:gallery-create|gallery-edit|gallery-delete|gallery-publish', ['only' => ['index', 'store']]);
        $this->middleware('permission:gallery-create', ['only' => ['store']]);
        $this->middleware('permission:gallery-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:gallery-delete', ['only' => ['destroy']]);
        $this->middleware('permission:gallery-publish', ['only' => ['status']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            $data = Gallery::with('users')->orderBy('created_at', 'desc')
                ->when(!empty($search), function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->paginate(10);
            return view('admin.gallery.dataTable', compact('data'))->render();
        } else {
            $data = Gallery::with('users')->orderBy('created_at', 'desc')->paginate(10);
            return view('admin.gallery.index', compact('data'));
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'photo' => 'required|mimes:png,jpg,jpeg|max:1024'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $gallery = new Gallery();
        $gallery->name = $request->name;
        $gallery->position = $request->position;
        $gallery->image_alt = $request->image_alt;
        $gallery->tag_line = $request->tag_line;
        if ($request->hasFile('photo')) {
            $gallery->photo = $request->file('photo')->store('uploads/gallery');
        }
        $gallery->uid = Auth::user()->id;
        if ($gallery->save()) {
            return redirect()->route('gallery.index')->with(['status' => 'success', 'message' => 'Insert Operation Successfully Done.']);
        } else {
            return redirect()->route('gallery.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }
    public function edit(Request $request)
    {
        $row = Gallery::findOrFail($request->id);

        $preview = (! empty($row->photo) && file_exists('storage/' . $row->photo))
            ? '<img loading="lazy" src="' . url('storage/' . $row->photo) . '" style="width: 80px; height: auto; margin-left: 20px; border-radius: 4px;">'
            : '';

        echo '<div class="modal-header">
            <h4 class="modal-title">Update Gallery Item</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="' . route('gallery.update') . '" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="' . csrf_token() . '" />
                <input type="hidden" name="id" value="' . $row->id . '" />
                <div class="card-body">
                    <div class="form-group">
                        <label for="position">Position</label>
                        <select class="form-control" name="position" required>
                            <option value="' . (int) $row->position . '" hidden>' . (int) $row->position . '</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Photo Title</label>
                        <input type="text" class="form-control" name="name" value="' . e($row->name) . '" required>
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="photo" accept="image/*" class="custom-file-input" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose Photo</label>
                            </div>
                            ' . $preview . '
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image_alt">Image Alt</label>
                        <input type="text" name="image_alt" value="' . e($row->image_alt) . '" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="tag_line">Tag Line</label>
                        <textarea name="tag_line" class="form-control">' . e($row->tag_line) . '</textarea>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update Records</button>
                </div>
            </form>
        </div>
        <script type="text/javascript">
            $(function() {
                if (typeof bsCustomFileInput !== "undefined") bsCustomFileInput.init();
            });
        </script>';
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $gallery = Gallery::findOrFail($request->id);
        $gallery->name = $request->name;
        $gallery->position = $request->position;
        $gallery->image_alt = $request->image_alt;
        $gallery->tag_line = $request->tag_line;
        if ($request->hasFile('photo')) {
            $photoValidator = Validator::make($request->all(), [
                'photo' => 'mimes:png,jpg,jpeg,webp|max:2048'
            ]);
            if ($photoValidator->fails()) {
                return redirect()->back()->withErrors($photoValidator)->withInput();
            }

            if (! empty($gallery->photo) && file_exists('storage/' . $gallery->photo)) {
                @unlink('storage/' . $gallery->photo);
            }
            $gallery->photo = $request->file('photo')->store('uploads/gallery');
        }
        $gallery->uid = Auth::user()->id;
        if ($gallery->save()) {
            return redirect()->route('gallery.index')->with(['status' => 'success', 'message' => 'Update Operation Successfully Done.']);
        } else {
            return redirect()->route('gallery.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }

    public function status(Request $request)
    {
        $gallery = Gallery::find($request->id);
        $gallery->status = $request->status;
        $gallery->uid = Auth::user()->id;
        if ($gallery->save()) {
            $data = [
                'status' => 'success',
            ];
        } else {
            $data = [
                'status' => 'error',
            ];
        }
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $res = Gallery::where('id', $request->id)->first();
        if ($res) {
            if (file_exists('storage/' . $res->photo) && !empty($res->photo)) {
                unlink('storage/' . $res->photo);
            }
            Gallery::where('id', $request->id)->delete();
            $data = [
                'status' => 'success',
                'message' => 'Your Record has been deleted'
            ];
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Something Wrong.!'
            ];
        }
        return response()->json($data);
    }
}
