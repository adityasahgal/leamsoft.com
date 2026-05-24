<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:permission-create|permission-edit|permission-delete|permission-publish', ['only' => ['index','store']]);
         $this->middleware('permission:permission-create', ['only' => ['store']]);
         $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
         $this->middleware('permission:permission-publish', ['only' => ['status']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::orderBy('created_at', 'DESC')->Where('name', 'LIKE', "%{$request->search}%")
                ->paginate(10);
            return view('admin.permission.dataTable', compact('data'))->render();
        } else {
            $data = Permission::orderBy('created_at', 'DESC')->paginate(10);
            return view('admin.permission.index', compact('data'));
        }
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:255'
        ], [
            'name.required' => 'A Permission name is required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('permission.index')->withErrors($validator)->withInput();
        }
        $perm = new Permission();
        $perm->name = $data['name'];


        if ($perm->save()) {
            return redirect()->route('permission.index')->with(['status' => 'success', 'message' => 'Insert Operation Successfully Done.']);
        } else {
            return redirect()->route('permission.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }


    public function edit(Request $request)
    {
        $row = Permission::where('id', $request->id)->first();
        return '<div class="modal-content card-primary card-outline">
        <div class="modal-header">
            <h4 class="modal-title">Update Permission</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="' . route("permission.update") . '" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="' . csrf_token() . '" />
            <input type="hidden" name="id" value="' . $row->id . '" />
                <div class="card-body">
              <div class="form-group">
                <label for="name">Permission Name</label>
                <input type="text" class="form-control" name="name" value="'.$row->name.'">
              </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Add Records</button>
                </div>
            </form>
        </div>
    </div>';
    }

    public function update(Request $request)
    {
        $data = $request->all();

        $perm = Permission::find($data['id']);
        $perm->name = $data['name'];
        if ($perm->save()) {
            return redirect()->route('permission.index')->with(['status' => 'success', 'message' => 'Update Operation Successfully Done.']);
        } else {
            return redirect()->route('permission.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }

    public function status(Request $request)
    {
        $perm = Permission::find($request->id);
        $perm->status = $request->status;
        if ($perm->save()) {
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
        $res = Permission::where('id', $request->id)->delete();
        if ($res) {
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
