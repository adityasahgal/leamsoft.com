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
use Symfony\Component\HttpFoundation\IpUtils;

class MainController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function about_us()
    {
        return view('frontend.about-us');
    }
    public function villas()
    {
        return view('frontend.villas');
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
        return view('frontend.blog');
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
        return view('frontend.gallery');
    }

    public function blog_details($slug)
    {
        $blogDetail = Blog::where('status', 1)->where('slug', $slug)->first();
        if ($blogDetail) {
            return view('frontend.blog-detail', compact('blogDetail'));
        }
        return abort(404);
    }

    public function getCateSlug($cateSlug)
    {
        $service = Service::where('status', 1)->where('slug', $cateSlug)->first();
        if ($service) {
            return view('frontend.view-product', ['productrow' => $service]);
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
        $rules = [
            'g-recaptcha-response' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'message' => 'required',
        ];
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
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response')
        ]);

        $body = $response->json();

        if (!$body['success']) {
            return back()->withErrors(['captcha' => 'reCAPTCHA verification failed.']);
        }
        try {
            // Create and save the enquiry
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
