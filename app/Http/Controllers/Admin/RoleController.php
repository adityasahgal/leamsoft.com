<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:role-create|role-edit|role-delete|role-publish', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update','grant','grantStore']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
         $this->middleware('permission:role-publish', ['only' => ['status']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::orderBy('created_at', 'DESC')->Where('name', 'LIKE', "%{$request->search}%")
                ->paginate(10);
            return view('admin.roles.dataTable', compact('data'))->render();
        } else {
            $data = Role::orderBy('created_at', 'DESC')->paginate(10);
            return view('admin.roles.index', compact('data'));
        }
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:255'
        ], [
            'name.required' => 'A Role name is required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('roles.index')->withErrors($validator)->withInput();
        }
        $roles = new Role();
        $roles->name = $data['name'];


        if ($roles->save()) {
            return redirect()->route('roles.index')->with(['status' => 'success', 'message' => 'Insert Operation Successfully Done.']);
        } else {
            return redirect()->route('roles.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }


    public function edit(Request $request)
    {
        $row = Role::where('id', $request->id)->first();
        return '<div class="modal-content card-primary card-outline">
        <div class="modal-header">
            <h4 class="modal-title">Update Permission</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="' . route("roles.update") . '" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="' . csrf_token() . '" />
            <input type="hidden" name="id" value="' . $row->id . '" />
                <div class="card-body">
              <div class="form-group">
                <label for="name">Permission Name</label>
                <input type="text" class="form-control" name="name" value="' . $row->name . '">
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

        $roles = Role::find($data['id']);
        $roles->name = $data['name'];
        if ($roles->save()) {
            return redirect()->route('roles.index')->with(['status' => 'success', 'message' => 'Update Operation Successfully Done.']);
        } else {
            return redirect()->route('roles.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }


    public function grant(Request $request)
    {
        $row = Role::where('id', $request->id)->first();
        $role = Role::findByName($row->name);
        $permission = $role->permissions->pluck('name');
        $permission = str_replace('"', '',  $permission);
        $permission = str_replace('[', '',  $permission);
        $permission = str_replace(']', '',  $permission);
        $permArr = explode(",", $permission);
        $data = Permission::where('status', 1)->get();
        echo '<div class="modal-header">
            <h4 class="modal-title">Grant Permission</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <div class="icheck-primary d-inline">
        <input type="checkbox" id="grantAll" style="height: 20px;width: 20px; z-index: 9999;">
         <label style="position: fixed;margin-top: -1px;margin-left: -1px;">Grant All Privileges</label>
       </div>
            <form action="' . route("roles.grantStore") . '" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="' . csrf_token() . '" />
            <input type="hidden" class="form-control" name="name" value="' . $row->name . '">
                <div class="card-body" style="margin-top: 15px;">
                <div class="row">';
        foreach ($data as $res) {
            echo '<div class="col-md-4">
                <div class="icheck-primary">
                 <input type="checkbox" name="permission[]" value="' . $res->name . '"  style="z-index: 9999;height: 20px;width: 20px;"';
            if (in_array($res->name, $permArr)) {
                echo 'checked';
            }

            echo '>
                  <label style="position: fixed;margin-top: -1px;margin-left: -1px;font-weight: 500;">' . ucfirst($res->name) . '</label>
                </div>
                </div>';
        }
        echo '</div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Permission</button>
                </div>
            </form>
        </div>
        <script>
  $("#grantAll").change(function() {
        $("input:checkbox").prop("checked", $(this).prop("checked"));
    });
</script>';
    }


    public function grantStore(Request $request)
    {
        $role = Role::findByName($request->name);
        if ($role->syncPermissions($request->permission)) {
            return redirect()->route('roles.index')->with(['status' => 'success', 'message' => 'Grant Permission Successfully Done.']);
        } else {
            return redirect()->route('roles.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }



    public function destroy(Request $request)
    {
        $res = Role::where('id', $request->id)->delete();
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
