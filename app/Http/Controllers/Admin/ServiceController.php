<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:service-create|service-edit|service-delete|service-publish', ['only' => ['index', 'store']]);
        $this->middleware('permission:service-create', ['only' => ['store']]);
        $this->middleware('permission:service-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:service-delete', ['only' => ['destroy']]);
        $this->middleware('permission:service-publish', ['only' => ['status']]);
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $q = $request->search;
            $status = $request->status;
            $records = $request->records;
            $data = Service::with(['users'])
                ->when(!empty($q), function ($qry) use ($q) {
                    $qry->Where('name', 'LIKE', "%{$q}%");
                })
                ->when(!empty($status), function ($query) use ($status) {
                    $query->where('status', $status);
                })
                ->orderBy('created_at', 'DESC')
                ->paginate($records);
            return view('admin.service.dataTable', compact('data'))->render();
        } else {
            $data = Service::with(['users'])->orderBy('created_at', 'DESC')->paginate(10);
            return view('admin.service.index', compact('data'));
        }
    }


    public function create()
    {
        return view('admin.service.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required|unique:services,name|max:255',
            ]);
            if ($validator->fails()) {
                return redirect()->route('service.create')->withErrors($validator)->withInput();
            }
            $service = new Service();
            $service->name = $request->name;

            if ($request->slug != null) {
                $service->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug)));
            } else {
                $service->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)));
            }

            $photos = array();

            if ($request->hasFile('photos')) {
                foreach ($request->photos as $key => $photo) {
                    $path = $photo->store('uploads/services/photos');
                    array_push($photos, $path);
                }
                $service->photos = json_encode($photos);
            }

            if ($request->hasFile('thumbnail_img')) {
                $service->thumbnail_img = $request->thumbnail_img->store('uploads/services/thumbnail');
            }

            $service->image_alt = $request->image_alt;
            $service->price = $request->price;
            $service->mrp_price = $request->mrp_price;
            $service->discount = $request->discount;
            $service->gst = $request->gst;
            $service->tax = $request->tax;
            $service->short_description = $request->short_description;
            $service->description = $request->description;
            $service->h1_tag = $request->h1_tag;
            $service->meta_title = $request->meta_title;
            $service->meta_description = $request->meta_description;
            $service->keywords = $request->keywords;
            $service->uid = Auth::user()->id;

            if ($service->save()) {
                return redirect()->route('service.index')->with(['status' => 'success', 'message' => 'Insert Operation Successfully Done.']);
            } else {
                return redirect()->route('service.index')->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
            }
        } catch (Exception $e) {
            return redirect()->route('service.create')->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function edit(Request $request)
    {
        $product = Service::with(['users'])->where('id', Crypt::decrypt($request->id))->first();
        if ($product) {
            return view('admin.service.edit', compact(['product']));
        } else {
            return abort(404);
        }
    }
    public function update(Request $request)
    {
        try {
            $data = $request->all();
            $service = Service::find(Crypt::decrypt($request->id));
            $service->name = $request->name;
            if ($request->slug != null) {
                $service->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug)));
            } else {
                $service->slug = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)));
            }

            if ($request->has('previous_photos')) {
                $photos = $request->previous_photos;
                $dbPhotoArr = json_decode($service->photos);
                $deletePhotoArr = array_diff($dbPhotoArr, $photos);
                foreach ($deletePhotoArr as $key => $photoRaw) {
                    if (file_exists('storage/' . $photoRaw) && !empty($photoRaw)) {
                        unlink('storage/' . $photoRaw);
                    }
                }
            } else {
                $photos = array();
            }

            if ($request->hasFile('photos')) {
                foreach ($request->photos as $key => $photo) {
                    $path = $photo->store('uploads/services/photos');
                    array_push($photos, $path);
                }
            }
            $service->photos = json_encode($photos);



            if ($request->hasFile('thumbnail_img')) {
                if (file_exists('storage/' . $service->thumbnail_img) && !empty($service->thumbnail_img)) {
                    unlink('storage/' . $service->thumbnail_img);
                }
                $service->thumbnail_img = $request->thumbnail_img->store('uploads/services/thumbnail');
            } else {
                $service->thumbnail_img = $request->previous_thumbnail_img;
            }
            $service->image_alt = $request->image_alt;
            $service->price = $request->price;
            $service->mrp_price = $request->mrp_price;
            $service->discount = $request->discount;
            $service->gst = $request->gst;
            $service->tax = $request->tax;
            $service->short_description = $request->short_description;
            $service->description = $request->description;
            $service->h1_tag = $request->h1_tag;
            $service->meta_title = $request->meta_title;
            $service->meta_description = $request->meta_description;
            $service->keywords = $request->keywords;
            $service->uid = Auth::user()->id;
            if ($service->save()) {
                return redirect()->route('service.index')->with(['status' => 'success', 'message' => 'Update Operation Successfully Done.']);
            } else {
                return redirect()->route('service.edit', $request->id)->with(['status' => 'error', 'message' => 'Something Wrong!. Please Try Again']);
            }
        } catch (Exception $e) {
            return redirect()->route('service.edit', $request->id)->with(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    public function status(Request $request)
    {
        $service = Service::find($request->id);
        if ($request->type == 'featured') {
            $service->featured = $request->status;
        } elseif ($request->type == 'top') {
            $service->top = $request->status;
        } else {
            $service->status = $request->status;
        }
        $service->uid = Auth::user()->id;
        if ($service->save()) {
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
        $res = Service::where('id', $request->id)->first();
        if ($res) {
            $dbPhotoArr = json_decode($res->photos);
            foreach ($dbPhotoArr as $key => $photoRaw) {
                if (file_exists('storage/' . $photoRaw) && !empty($photoRaw)) {
                    unlink('storage/' . $photoRaw);
                }
            }
            if (file_exists('storage/' . $res->thumbnail_img) && !empty($res->thumbnail_img)) {
                unlink('storage/' . $res->thumbnail_img);
            }
            Service::where('id', $request->id)->delete();
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
