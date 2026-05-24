<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function index()
    {
       // Artisan::call('storage:link');
        $generalsetting = Setting::first();
        return view("admin.setting.index", compact("generalsetting"));
    }

   
    public function update(Request $request)
    {
        $generalsetting = Setting::first();
        $generalsetting->site_name = $request->name;
        $generalsetting->address = $request->address;
        $generalsetting->phone = $request->phone;
        $generalsetting->email = $request->email;
        $generalsetting->description = $request->description;
        $generalsetting->facebook = $request->facebook;
        $generalsetting->instagram = $request->instagram;
        $generalsetting->linkedin = $request->linkedin;
        $generalsetting->twitter = $request->twitter;
        $generalsetting->youtube = $request->youtube;
        $generalsetting->google_plus = $request->google_plus;
        
        if($request->hasFile('logo')){
            if (file_exists('storage/' . $generalsetting->logo) && !empty($generalsetting->logo)) {
                unlink('storage/' . $generalsetting->logo);
            }
            $generalsetting->logo = $request->file('logo')->store('uploads/logo');
        }

       if($request->hasFile('favicon')){
        if (file_exists('storage/' . $generalsetting->favicon) && !empty($generalsetting->favicon)) {
            unlink('storage/' . $generalsetting->favicon);
        }
            $generalsetting->favicon = $request->file('favicon')->store('uploads/favicon');
        }

        if ($generalsetting->save()) {
            return redirect()->route('setting.index')->with(['status' => 'success', 'message' => 'Update Operation Successfully Done.']);
        } else {
            return redirect()->route('setting.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
        }
    }
}
