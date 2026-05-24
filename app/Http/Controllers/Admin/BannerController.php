<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:banner-create|banner-edit|banner-delete|banner-publish', ['only' => ['index', 'store']]);
        $this->middleware('permission:banner-create', ['only' => ['store']]);
        $this->middleware('permission:banner-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:banner-delete', ['only' => ['destroy']]);
        $this->middleware('permission:banner-publish', ['only' => ['status']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            $data = Banner::with('users')->orderBy('created_at', 'desc')
                ->when(!empty($search), function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->paginate(10);
            return view('admin.banner.dataTable', compact('data'))->render();
        } else {
            $data = Banner::with('users')->orderBy('created_at', 'desc')->paginate(10);
            return view('admin.banner.index', compact('data'));
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'banner' => 'required|mimes:png,jpg,jpeg|max:1024'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $banner = new Banner;
        $banner->name = $request->name;
        $banner->url_link = $request->url_link;
        $banner->position = $request->position;
        $banner->image_alt = $request->image_alt;
        $banner->tag_line = $request->tag_line;
        if ($request->hasFile('banner')) {
            $banner->banner = $request->file('banner')->store('uploads/banner');
        }
        $banner->uid = Auth::user()->id;
        if ($banner->save()) {
            return redirect()->route('banner.index')->with(['status' => 'success', 'message' => 'Insert Operation Successfully Done.']);
        } else {
            return redirect()->route('banner.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }
    public function edit(Request $request)
    {

        $row = Banner::findOrFail($request->id);
        echo '<div class="modal-header">
        <h4 class="modal-title">Update Banner</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="' . route("banner.update") . '" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="' . csrf_token() . '" />
        <input type="hidden" name="id" value="' . $row->id . '" />
        <div class="card-body">
        <div class="form-group">
         <label for="position">Position</label>
         <select class="form-control" name="position" required>
             <option value="' . $row->position . '" hidden>' . $row->position . '</option>
             <option value="1">1</option>
             <option value="2">2</option>
             <option value="3">3</option>
             <option value="4">4</option>
             <option value="5">5</option>
         </select>
       </div>
       <div class="form-group">
         <label for="link">URL Link</label>
         <input type="text" class="form-control" name="url_link" value="' . $row->url_link . '" required>
       </div>
       <div class="form-group">
         <label for="title">Banner Title</label>
         <input type="text" class="form-control" name="name" value="' . $row->name . '" required>
       </div>
       <div class="form-group">
         <label for="banner">Banner</label>
         <div class="input-group">
         <div class="custom-file">
           <input type="file" name="banner" accept="image/*" class="custom-file-input" id="customFile">
           <label class="custom-file-label" for="customFile">Choose Banner</label>
         </div>';
        if (file_exists('storage/' . $row->banner) && !empty($row->banner)) {
            echo '<img loading="lazy" src="' . url('storage/' . $row->banner) . '" style="width: 60px;height: 38px;margin-left: 20px;">';
        }
        echo '</div>
       </div>
      <div class="form-group">
         <label for="image_alt">Image Alt</label>
         <input type="text" name="image_alt" value="' . $row->image_alt . '" class="form-control">
       </div>
       
        <div class="form-group">
         <label for="tag_line">Tag Line</label>
         <textarea name="tag_line" class="form-control">' . $row->tag_line . '</textarea>
       </div>
     </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update Records</button>
            </div>
        </form>
    </div>
    <script type="text/javascript">
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

        $banner = Banner::findOrFail($request->id);
        $banner->name = $request->name;
        $banner->url_link = $request->url_link;
        $banner->position = $request->position;
        $banner->image_alt = $request->image_alt;
        $banner->tag_line = $request->tag_line;
        if ($request->hasFile('banner')) {
            $validator = Validator::make($request->all(), [
                'banner' => 'required|mimes:png,jpg,jpeg|max:1024'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if (file_exists('storage/' . $banner->banner) && !empty($banner->banner)) {
                unlink('storage/' . $banner->banner);
            }
            $banner->banner = $request->file('banner')->store('uploads/banner');
        }
        $banner->uid = Auth::user()->id;
        if ($banner->save()) {
            return redirect()->route('banner.index')->with(['status' => 'success', 'message' => 'Update Operation Successfully Done.']);
        } else {
            return redirect()->route('banner.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }

    public function status(Request $request)
    {
        $banner = Banner::find($request->id);
        $banner->status = $request->status;
        $banner->uid = Auth::user()->id;
        if ($banner->save()) {
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
        $res = Banner::where('id', $request->id)->first();
        if ($res) {
            if (file_exists('storage/' . $res->banner) && !empty($res->banner)) {
                unlink('storage/' . $res->banner);
            }
            Banner::where('id', $request->id)->delete();
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
