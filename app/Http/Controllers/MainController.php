<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Enquiry;
use App\Models\Service;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)->orderBy('sort_order')->take(6)->get();
        $featuredServices = Service::where('status', 1)
            ->where('featured', 1)
            ->orderBy('sort_order')
            ->take(6)
            ->get();
        $latestBlogs = Blog::where('status', 1)->latest()->take(3)->get();

        return view('frontend.index', compact('categories', 'featuredServices', 'latestBlogs'));
    }

    public function about_us()
    {
        return view('frontend.about-us');
    }

    /**
     * Services listing page — shows all categories with their subcategories.
     */
    public function villas()
    {
        $categories = Category::with(['subcategories', 'services'])
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();

        return view('frontend.villas', compact('categories'));
    }

    public function near_by()
    {
        return view('frontend.near_by');
    }

    public function privacy_policy()
    {
        return view('frontend.privacy-policy');
    }

    public function contact_us()
    {
        return view('frontend.contact-us');
    }

    public function blog()
    {
        $blogs = Blog::where('status', 1)->latest()->paginate(9);
        return view('frontend.blog', compact('blogs'));
    }

    public function termcondition()
    {
        return view('frontend.terms-condition');
    }

    public function faq()
    {
        return view('frontend.faq');
    }

    public function help()
    {
        return view('frontend.help');
    }

    public function gallery()
    {
        $services = Service::where('status', 1)->latest()->get();
        return view('frontend.gallery', compact('services'));
    }

    public function blog_details($slug)
    {
        $blogDetail = Blog::where('status', 1)->where('slug', $slug)->first();
        if ($blogDetail) {
            $related = Blog::where('status', 1)->where('id', '!=', $blogDetail->id)->latest()->take(3)->get();
            return view('frontend.blog-detail', compact('blogDetail', 'related'));
        }
        return abort(404);
    }

    /**
     * Resolve a single slug — could be a category, subcategory, or service.
     * Resolution order: category → subcategory → service.
     */
    public function getCateSlug($cateSlug)
    {
        // 1. Try category
        $categories = Category::where('status', 1)->where('slug', $cateSlug)->first();
        if ($categories) {
            $subcategories = Subcategory::where('status', 1)
                ->where('category_id', $categories->id)
                ->orderBy('sort_order')
                ->get();
            $services = Service::where('status', 1)
                ->where('category_id', $categories->id)
                ->orderBy('sort_order')
                ->get();
            return view('frontend.view-category', compact('categories', 'subcategories', 'services'));
        }

        // 2. Try subcategory
        $subcategory = Subcategory::where('status', 1)->where('slug', $cateSlug)->first();
        if ($subcategory) {
            $categories = $subcategory->category;
            $services = Service::where('status', 1)
                ->where('subcategory_id', $subcategory->id)
                ->orderBy('sort_order')
                ->get();
            return view('frontend.view-subcategory', compact('categories', 'subcategory', 'services'));
        }

        // 3. Try service
        $service = Service::where('status', 1)->where('slug', $cateSlug)->first();
        if ($service) {
            $related = Service::where('status', 1)
                ->where('id', '!=', $service->id)
                ->when($service->subcategory_id, fn($q) => $q->where('subcategory_id', $service->subcategory_id))
                ->orWhere(fn($q) => $q->where('category_id', $service->category_id)->where('id', '!=', $service->id))
                ->take(3)
                ->get();
            return view('frontend.view-product', ['productrow' => $service, 'related' => $related]);
        }

        return abort(404);
    }

    public function showEnquiryModal(Request $request)
    {
        $data = Service::find($request->id);
        return view('frontend.showEnquiryForm', compact('data'));
    }

    public function storeEnquiry(Request $request)
    {
        try {
            $enquiry = new Enquiry();
            $enquiry->pname = $request->pname;
            $enquiry->name = $request->name;
            $enquiry->email = $request->email;
            $enquiry->phone = $request->phone;
            $enquiry->message = $request->message;

            if ($enquiry->save()) {
                return redirect()->back()->with(['status' => 'success', 'message' => 'Your enquiry has been sent successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    public function enquiry(Request $request)
    {
        $recaptchaEnabled = env('RECAPTCHA_ENABLED') && env('RECAPTCHA_SECRET_KEY');

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'message' => 'required',
        ];
        if ($recaptchaEnabled) {
            $rules['g-recaptcha-response'] = 'required';
        }
        $customMessages = [
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA to proceed.',
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.max' => 'The email may not be greater than 255 characters.',
            'phone.required' => 'The phone field is required.',
            'phone.numeric' => 'The phone must be a valid number.',
            'phone.digits_between' => 'The phone number must be between 10 and 15 digits.',
            'message.required' => 'The message field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verify reCAPTCHA
        if ($recaptchaEnabled) {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response')
            ]);

            $body = $response->json();

            if (!($body['success'] ?? false)) {
                return back()->withErrors(['captcha' => 'reCAPTCHA verification failed.'])->withInput();
            }
        }
        try {
            $enquiry = new Enquiry();
            $enquiry->name = $request->name;
            $enquiry->email = $request->email;
            $enquiry->phone = $request->phone;
            $enquiry->message = $request->message;

            if ($enquiry->save()) {
                return redirect()->back()->with(['status' => 'success', 'message' => 'Your enquiry has been sent successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }
}
