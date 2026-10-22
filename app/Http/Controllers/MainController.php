<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Client;
use App\Models\Enquiry;
use App\Models\Service;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Mail\EnquiryReceived;
use App\Support\Seo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories')->where('status', 1)->orderBy('sort_order')->take(6)->get();
        $featuredServices = Service::with(['category', 'subcategory'])
            ->where('status', 1)
            ->where('featured', 1)
            ->orderBy('sort_order')
            ->take(6)
            ->get();
        $latestBlogs = Blog::where('status', 1)->latest()->take(3)->get();
        $clients = Client::where('status', 1)->orderBy('sort_order')->latest()->get();

        $seo = Seo::page('home');

        return view('frontend.index', compact('categories', 'featuredServices', 'latestBlogs', 'clients', 'seo'));
    }

    public function about_us()
    {
        return view('frontend.about-us', ['seo' => Seo::page('about')]);
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

        // Feed the live category names into the keyword pool so the services
        // page targets whatever the admin has actually published.
        $seo = Seo::page('services', [
            'keywords' => Seo::keywords($categories->pluck('name')->take(6)->all()),
        ]);

        return view('frontend.villas', compact('categories', 'seo'));
    }

    public function near_by()
    {
        return view('frontend.near_by', ['seo' => Seo::page('near_by')]);
    }

    public function privacy_policy()
    {
        return view('frontend.privacy-policy', ['seo' => Seo::page('privacy')]);
    }

    public function contact_us()
    {
        return view('frontend.contact-us', ['seo' => Seo::page('contact')]);
    }

    public function blog()
    {
        $blogs = Blog::where('status', 1)->latest()->paginate(9);
        return view('frontend.blog', compact('blogs'))
            ->with('seo', Seo::page('blog'));
    }

    public function termcondition()
    {
        return view('frontend.terms-condition', ['seo' => Seo::page('terms')]);
    }

    public function faq()
    {
        return view('frontend.faq', ['seo' => Seo::page('faq')]);
    }

    public function help()
    {
        return view('frontend.help', ['seo' => Seo::page('help')]);
    }

    public function gallery()
    {
        $services = Service::with(['category', 'subcategory'])->where('status', 1)->latest()->get();
        return view('frontend.gallery', compact('services'))
            ->with('seo', Seo::page('gallery'));
    }

    public function blog_details($slug)
    {
        $blogDetail = Blog::where('status', 1)->where('slug', $slug)->first();
        if ($blogDetail) {
            $related = Blog::where('status', 1)->where('id', '!=', $blogDetail->id)->latest()->take(3)->get();

            $seo = Seo::article($blogDetail, [
                'breadcrumbs' => [
                    'Home'          => url('/'),
                    'Blog'          => url('blog'),
                    $blogDetail->name => url('blog/' . $blogDetail->slug),
                ],
            ]);

            return view('frontend.blog-detail', compact('blogDetail', 'related', 'seo'));
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
            // Keyword pool = the category itself plus everything under it
            $terms = collect([$categories->name])
                ->merge($subcategories->pluck('name'))
                ->filter()
                ->values()
                ->all();

            $seo = Seo::model($categories, 'Services', [
                'keywords'    => Seo::keywords($terms, $this->adminKeywords($categories)),
                'breadcrumbs' => [
                    'Home'              => url('/'),
                    'Services'          => url('services'),
                    $categories->name   => url($categories->slug),
                ],
            ]);

            return view('frontend.view-category', compact('categories', 'subcategories', 'services', 'seo'));
        }

        // 2. Try subcategory
        $subcategory = Subcategory::where('status', 1)->where('slug', $cateSlug)->first();
        if ($subcategory) {
            $categories = $subcategory->category;
            $services = Service::where('status', 1)
                ->where('subcategory_id', $subcategory->id)
                ->orderBy('sort_order')
                ->get();
            $trail = ['Home' => url('/'), 'Services' => url('services')];
            if ($categories) {
                $trail[$categories->name] = url($categories->slug);
            }
            $trail[$subcategory->name] = url($subcategory->slug);

            $seo = Seo::model($subcategory, 'Services', [
                'breadcrumbs' => $trail,
            ]);

            return view('frontend.view-subcategory', compact('categories', 'subcategory', 'services', 'seo'));
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
            $trail = ['Home' => url('/'), 'Services' => url('services')];
            if ($service->category) {
                $trail[$service->category->name] = url($service->category->slug);
            }
            $trail[$service->name] = url($service->slug);

            $seo = Seo::model($service, 'Services', [
                'breadcrumbs' => $trail,
            ]);

            return view('frontend.view-product', [
                'productrow' => $service,
                'related'    => $related,
                'seo'        => $seo,
            ]);
        }

        return abort(404);
    }

    /**
     * Admin-entered keywords for a record, as an array. These are seeded
     * ahead of the generated permutations so hand-picked terms survive the
     * keyword_max trim.
     */
    private function adminKeywords($row): array
    {
        if (empty($row->keywords)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode(',', $row->keywords))));
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
                $this->notifyEnquiry($enquiry);
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
        $recaptchaEnabled = config('recaptcha.enabled') && config('recaptcha.secret_key');

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
            'message' => 'required',
            'company' => 'nullable|string|max:255',
            'interest' => 'nullable|array',
            'interest.*' => 'string|max:100',
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
                'secret' => config('recaptcha.secret_key'),
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
            $enquiry->message = $this->composeMessage($request);

            if ($enquiry->save()) {
                $this->notifyEnquiry($enquiry);
                return redirect()->back()->with(['status' => 'success', 'message' => 'Your enquiry has been sent successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => 'danger', 'message' => $e->getMessage()]);
        }
    }

    /**
     * The enquiries table only has a message column, so the optional company
     * and "what can we help with" picks from the contact form are prepended.
     */
    private function composeMessage(Request $request): string
    {
        $lines = [];
        if ($request->filled('company')) {
            $lines[] = 'Company: ' . $request->company;
        }
        $interests = array_filter((array) $request->input('interest', []));
        if ($interests) {
            $lines[] = 'Interested in: ' . implode(', ', $interests);
        }

        return $lines
            ? implode("\n", $lines) . "\n\n" . $request->message
            : (string) $request->message;
    }

    /**
     * Email the enquiry to the admin inbox. Failures are logged, never shown
     * to the visitor -- the enquiry is already saved at this point.
     */
    private function notifyEnquiry(Enquiry $enquiry)
    {
        try {
            Mail::to(config('mail.enquiry_to'))->send(new EnquiryReceived($enquiry));
        } catch (\Exception $e) {
            Log::error('Enquiry mail failed: ' . $e->getMessage());
        }
    }
}
