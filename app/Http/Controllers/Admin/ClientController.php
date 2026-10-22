<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:client-create|client-edit|client-delete|client-publish', ['only' => ['index', 'store']]);
        $this->middleware('permission:client-create', ['only' => ['store']]);
        $this->middleware('permission:client-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:client-delete', ['only' => ['destroy']]);
        $this->middleware('permission:client-publish', ['only' => ['status']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search;
            $data = Client::with('users')->orderBy('sort_order')->orderBy('created_at', 'desc')
                ->when(!empty($search), function ($query) use ($search) {
                    $query->where('name', 'like', '%' . $search . '%')
                        ->orWhere('company', 'like', '%' . $search . '%');
                })
                ->paginate(10);
            return view('admin.client.dataTable', compact('data'))->render();
        } else {
            $data = Client::with('users')->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(10);
            return view('admin.client.index', compact('data'));
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'logo' => 'required|mimes:png,jpg,jpeg,webp,svg|max:1024'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $client = new Client;
        $client->name = $request->name;
        $client->designation = $request->designation;
        $client->company = $request->company;
        $client->website = $request->website;
        $client->image_alt = $request->image_alt;
        $client->testimonial = $request->testimonial;
        $client->sort_order = $request->sort_order ?? 0;
        $client->featured = $request->featured ? 1 : 0;
        if ($request->hasFile('logo')) {
            $client->logo = $request->file('logo')->store('uploads/clients');
        }
        $client->uid = Auth::user()->id;
        if ($client->save()) {
            return redirect()->route('client.index')->with(['status' => 'success', 'message' => 'Insert Operation Successfully Done.']);
        } else {
            return redirect()->route('client.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }

    public function edit(Request $request)
    {
        $row = Client::findOrFail($request->id);
        echo '<div class="modal-header">
        <h4 class="modal-title">Update Client</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="' . route("client.update") . '" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="' . csrf_token() . '" />
        <input type="hidden" name="id" value="' . $row->id . '" />
        <div class="card-body">
        <div class="form-group">
          <label for="name">Client Name</label>
          <input type="text" class="form-control" name="name" value="' . $row->name . '" required>
        </div>
        <div class="form-group">
          <label for="designation">Designation</label>
          <input type="text" class="form-control" name="designation" value="' . $row->designation . '">
        </div>
        <div class="form-group">
          <label for="company">Company</label>
          <input type="text" class="form-control" name="company" value="' . $row->company . '">
        </div>
        <div class="form-group">
          <label for="website">Website</label>
          <input type="text" class="form-control" name="website" value="' . $row->website . '">
        </div>
        <div class="form-group">
          <label for="logo">Logo / Photo</label>
          <div class="input-group">
          <div class="custom-file">
            <input type="file" name="logo" accept="image/*" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Choose Logo</label>
          </div>';
        if (file_exists('storage/' . $row->logo) && !empty($row->logo)) {
            echo '<img loading="lazy" src="' . url('storage/' . $row->logo) . '" style="width: 60px;height: 38px;margin-left: 20px;">';
        }
        echo '</div>
        </div>
        <div class="form-group">
          <label for="image_alt">Image Alt</label>
          <input type="text" name="image_alt" value="' . $row->image_alt . '" class="form-control">
        </div>
        <div class="form-group">
          <label for="testimonial">Testimonial</label>
          <textarea name="testimonial" class="form-control">' . $row->testimonial . '</textarea>
        </div>
        <div class="form-group">
          <label for="sort_order">Sort Order</label>
          <input type="number" name="sort_order" value="' . $row->sort_order . '" class="form-control">
        </div>
        <div class="form-group">
          <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="editFeatured" name="featured" value="1" ' . ($row->featured ? 'checked' : '') . '>
            <label class="custom-control-label" for="editFeatured">Featured</label>
          </div>
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

        $client = Client::findOrFail($request->id);
        $client->name = $request->name;
        $client->designation = $request->designation;
        $client->company = $request->company;
        $client->website = $request->website;
        $client->image_alt = $request->image_alt;
        $client->testimonial = $request->testimonial;
        $client->sort_order = $request->sort_order ?? 0;
        $client->featured = $request->featured ? 1 : 0;
        if ($request->hasFile('logo')) {
            $validator = Validator::make($request->all(), [
                'logo' => 'required|mimes:png,jpg,jpeg,webp,svg|max:1024'
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if (file_exists('storage/' . $client->logo) && !empty($client->logo)) {
                unlink('storage/' . $client->logo);
            }
            $client->logo = $request->file('logo')->store('uploads/clients');
        }
        $client->uid = Auth::user()->id;
        if ($client->save()) {
            return redirect()->route('client.index')->with(['status' => 'success', 'message' => 'Update Operation Successfully Done.']);
        } else {
            return redirect()->route('client.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }

    public function status(Request $request)
    {
        $client = Client::find($request->id);
        $client->status = $request->status;
        $client->uid = Auth::user()->id;
        if ($client->save()) {
            $data = ['status' => 'success'];
        } else {
            $data = ['status' => 'error'];
        }
        return response()->json($data);
    }

    public function destroy(Request $request)
    {
        $res = Client::where('id', $request->id)->first();
        if ($res) {
            if (file_exists('storage/' . $res->logo) && !empty($res->logo)) {
                unlink('storage/' . $res->logo);
            }
            Client::where('id', $request->id)->get()->each->delete(); // per-model so cache-flush events fire
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
