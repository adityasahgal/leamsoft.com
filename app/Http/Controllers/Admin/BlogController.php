<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:blog-create|blog-edit|blog-delete|blog-publish', ['only' => ['index', 'store']]);
        $this->middleware('permission:blog-create', ['only' => ['store']]);
        $this->middleware('permission:blog-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
        $this->middleware('permission:blog-publish', ['only' => ['status']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            $data = Blog::with('users')->orderBy('created_at', 'desc')
                ->when(!empty($search), function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->paginate(10);
            return view('admin.blog.dataTable', compact('data'))->render();
        } else {
            $data = Blog::with('users')->orderBy('created_at', 'desc')->paginate(10);
            return view('admin.blog.index', compact('data'));
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:blogs,name|max:255'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $blog = new Blog();
        $blog->name = $request->name;
        $blog->short_description = $request->short_description;
        $blog->description = $request->description;
        $blog->image_alt = $request->image_alt;
        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->keywords = $request->keywords;
        if ($request->slug != null) {
            $blog->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug)));
        } else {
            $blog->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5));
        }

        if ($request->hasFile('banner')) {
            $validator = Validator::make($request->all(), [
                'banner' => 'required|mimes:png,jpg,jpeg|max:1024'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $blog->banner = $request->file('banner')->store('uploads/blogs/banner');
        }
        $blog->uid = Auth::user()->id;
        if ($blog->save()) {
            return redirect()->route('blog.index')->with(['status' => 'success', 'message' => 'Insert Operation Successfully Done.']);
        } else {
            return redirect()->route('blog.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }
    public function edit(Request $request)
    {

        $row = Blog::findOrFail($request->id);
        echo '<div class="modal-header">
        <h4 class="modal-title">Update Banner</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="' . route("blog.update") . '" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="' . csrf_token() . '" />
        <input type="hidden" name="id" value="' . $row->id . '" />
        <div class="card-body">
        <div class="form-group">
          <label for="name">Blog Name</label>
          <input type="text" class="form-control" name="name" value="' . $row->name . '" required>
        </div>
        <div class="form-group">
          <label for="banner">Banner</label>
          <div class="input-group row">
          <div class="custom-file col-md-8">
            <input type="file" name="banner" class="custom-file-input" accept="image/*" id="customFile">
            <label class="custom-file-label" for="customFile">Choose Banner</label>
          </div>
          <div class="col-md-4 text-center">';
        if (file_exists('storage/' . $row->banner) && !empty($row->banner)) {
            echo '<img loading="lazy" src="' . url('storage/' . $row->banner) . '" style="width: 60px;height: 38px;margin-left: 20px;">';
        }
        echo '</div>
          </div>
        </div>
         <div class="form-group">
          <label for="short_description">Short Description</label>
          <div class="input-group">
          <textarea name="short_description" class="form-control">' . $row->short_description . '</textarea>
          </div>
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="edittextarea" name="description" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">' . $row->description . '</textarea>
        </div>

          <div class="form-group">
          <label for="slug">Blog Slug</label>
          <input type="text" class="form-control" name="slug" value="' . $row->slug . '" required>
        </div>
        
         <div class="form-group">
          <label for="image_alt">Image Alt</label>
          <input type="text" name="image_alt" class="form-control" value="' . $row->image_alt . '">
        </div>
       <div class="form-group">
          <label for="meta_title">Meta Title</label>
          <input type="text" name="meta_title" class="form-control" value="' . $row->meta_title . '">
        </div>

        <div class="form-group">
          <label for="meta_description">Meta Description</label>
          <textarea name="meta_description" class="form-control" placeholder="Text Here">' . $row->meta_description . '</textarea>
        </div>
        <div class="form-group">
          <label for="keywords">Keywords</label>
          <textarea name="keywords" class="form-control" placeholder="Text Here">' . $row->keywords . '</textarea>
        </div>
      </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update Records</button>
            </div>
        </form>
    </div>
    <script type="text/javascript">
    $(function() {
        $("#edittextarea").summernote()
      });
  $(function() {
    bsCustomFileInput.init();
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

        $blog = Blog::findOrFail($request->id);
        $blog->name = $request->name;
        $blog->short_description = $request->short_description;
        $blog->description = $request->description;
        $blog->image_alt = $request->image_alt;
        $blog->meta_title = $request->meta_title;
        $blog->meta_description = $request->meta_description;
        $blog->keywords = $request->keywords;
        if ($request->slug != null) {
            $blog->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug)));
        } else {
            $blog->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)) . '-' . Str::random(5));
        }
        if ($request->hasFile('banner')) {
            $validator = Validator::make($request->all(), [
                'banner' => 'required|mimes:png,jpg,jpeg|max:1024'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if (file_exists('storage/' . $blog->banner) && !empty($blog->banner)) {
                unlink('storage/' . $blog->banner);
            }
            $blog->banner = $request->file('banner')->store('uploads/blogs/banner');
        }
        $blog->uid = Auth::user()->id;
        if ($blog->save()) {
            return redirect()->route('blog.index')->with(['status' => 'success', 'message' => 'Update Operation Successfully Done.']);
        } else {
            return redirect()->route('blog.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }

    public function status(Request $request)
    {
        $blog = Blog::find($request->id);
        $blog->status = $request->status;
        $blog->uid = Auth::user()->id;
        if ($blog->save()) {
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
        $res = Blog::where('id', $request->id)->first();
        if ($res) {
            if (file_exists('storage/' . $res->banner) && !empty($res->banner)) {
                unlink('storage/' . $res->banner);
            }
            Blog::where('id', $request->id)->delete();
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
