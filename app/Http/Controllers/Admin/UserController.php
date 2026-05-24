<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
  function __construct()
  {
    $this->middleware('permission:user-create|user-edit|user-delete|user-publish', ['only' => ['index', 'store']]);
    $this->middleware('permission:user-create', ['only' => ['store']]);
    $this->middleware('permission:user-edit', ['only' => ['edit', 'update', 'userExports']]);
    $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    $this->middleware('permission:user-publish', ['only' => ['status']]);
  }

  public function index(Request $request)
  {
    $roles = Role::orderBy('id', 'ASC')->get();
    if ($request->ajax()) {
      $q = $request->search;
      $status = $request->status;
      $records = $request->records;
      $role = $request->role;
      $data = User::with(['roles'])
        ->when(!empty($status), function ($query) use ($status) {
          $query->where('status', $status);
        })
        ->when(!empty($q), function ($qry) use ($q) {
          $qry->Where('name', 'LIKE', "%{$q}%");
          $qry->orWhere('email', 'LIKE', "%{$q}%");
        })
        ->when(!empty($role), function ($query) use ($role) {
          $query->whereHas('roles', function ($query) use ($role) {
            $query->whereIn('name', $role);
          });
        })
        ->orderBy('created_at', 'DESC')
        ->paginate($records);
      return view('admin.users.dataTable', compact(['data', 'roles']))->render();
    } else {
      $data = User::with(['roles'])->orderBy('created_at', 'DESC')->paginate(10);
      return view('admin.users.index', compact(['data', 'roles']));
    }
  }


  public function create()
  {
    $roles = Role::orderBy('id', 'ASC')->get();
    $users = User::orderBy('id', 'ASC')->get();
    return view('admin.users.create', compact(['roles', 'users']));
  }

  public function store(Request $request)
  {
    $data = $request->all();
    $validator = Validator::make($data, [
      'email' => 'required|max:255',
    ]);
    if ($validator->fails()) {
      return redirect()->route('users.create')->withErrors($validator)->withInput();
    }
    $user = new User();
    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->designation = $data['designation'];
    $user->phone = $data['phone'];
    $user->uid = Auth::user()->id;
    $user->password = Hash::make('Admin@321');
    if ($user->save()) {
      $user->assignRole($data['role']);
      return redirect()->route('users.index')->with(['status' => 'success', 'message' => 'Insert Operation Successfully Done.']);
    } else {
      return redirect()->route('users.create')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
    }
  }

  public function edit(Request $request)
  {
    $row = User::with('roles')->where('id', Crypt::decrypt($request->id))->first();
    if ($row) {
      $roleName = trim($row->roles->pluck('name'), '[""]');
      $roles = Role::orderBy('id', 'ASC')->get();
      $users = User::orderBy('id', 'ASC')->get();
      return view('admin.users.edit', compact(['roles', 'users', 'row', 'roleName']));
    } else {
      return abort(404);
    }
  }

  public function update(Request $request)
  {
    try {
      $data = $request->all();
      $user = User::find(Crypt::decrypt($request->id));
      $user->name = $data['name'];
      $user->email = $data['email'];
      $user->designation = $data['designation'];
      $user->phone = $data['phone'];
      $user->uid = Auth::user()->id;
      if ($user->save()) {
        $user->syncRoles($data['role']);
        return redirect()->route('users.index')->with(['status' => 'success', 'message' => 'Update Operation Successfully Done.']);
      } else {
        return redirect()->route('users.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
      }
    } catch (Exception $e) {
      // dd($e->getMessage());
      return redirect()->route('users.index')->with(['status' => 'error', 'message' => $e->getMessage()]);
    }
  }

  public function userExports(Request $request)
  {

    $q = $request->search;
    $status = $request->status;
    $role = $request->role;

    $file_name = 'users_' . date('Y_m_d_H_i_s') . '.xlsx';
    return Excel::download(new UsersExport($q, $status, $role), $file_name, \Maatwebsite\Excel\Excel::XLSX);
  }


  public function status(Request $request)
  {
    $user = User::find($request->id);
    $user->status = $request->status;
    if ($user->save()) {
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
    $res = User::where('id', $request->id)->delete();
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
  
  public function changePassword()
  {
    return view('admin.users.password');
  }


  public function updatePassword(Request $request)
  {
    try {
      // Validation
      $request->validate([
        'old_password' => 'required',
        'new_password' => [
          'required',
          'confirmed',
          Password::min(8)
            ->letters()          // Must contain at least one letter
            ->mixedCase()        // Must contain both upper and lower case letters
            ->numbers()          // Must contain at least one number
            ->symbols()          // Must contain at least one special character
        ]
      ]);

      // Match The Old Password
      if (!Hash::check($request->old_password, Auth::user()->password)) {
        return back()->with("error", "Old password doesn't match!");
      }

      // Update the new Password
      Auth::user()->update([
        'password' => Hash::make($request->new_password)
      ]);

      return back()->with("status", "Password changed successfully!");
    } catch (ValidationException $e) {
      // Return validation error messages
      return back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
      return back()->with("error", "An error occurred: " . $e->getMessage());
    }
  }
  
}
