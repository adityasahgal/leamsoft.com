<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Enquiry;
use App\Models\Service;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:admin-dashboard', ['only' => ['index']]);
    }


    public function index()
    {
        $serviceCounts = Service::count();
        $blogCounts = Blog::count();
        $enquiryCounts = Enquiry::count();
        $latestEnquiries = Enquiry::orderBy('created_at', 'DESC')->take(10)->get();
        $meetingCounts = \App\Models\Meeting::upcoming()->count();
        $upcomingMeetings = \App\Models\Meeting::upcoming()->take(5)->get();
        return view('admin.dashboard.index', compact(['serviceCounts', 'blogCounts', 'enquiryCounts', 'latestEnquiries', 'meetingCounts', 'upcomingMeetings']));
    }


    /**
     * The sitemap is now built live from the database at /sitemap.xml.
     * This just drops the cached copy so the next request rebuilds it.
     */
    public function generate()
    {
        foreach (\App\Http\Controllers\SeoController::CACHE_KEYS as $key) {
            \Illuminate\Support\Facades\Cache::forget($key);
        }

        return redirect()->route('sitemap');
    }
}
