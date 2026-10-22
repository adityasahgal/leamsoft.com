<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Support\Ui;
use Illuminate\Support\Facades\Cache;

/**
 * Machine-readable views of the site, built from the database so they never
 * drift from what is published: XML sitemap, RSS feed and /llms.txt.
 *
 * Each is cached for an hour and flushed whenever content changes
 * (see AppServiceProvider::flushSiteCaches).
 */
class SeoController extends Controller
{
    public const CACHE_KEYS = ['seo.sitemap', 'seo.feed', 'seo.llms'];

    /** Public static pages: path => [priority, changefreq] */
    private const PAGES = [
        '/'               => ['1.0', 'weekly'],
        'services'        => ['0.9', 'weekly'],
        'about-us'        => ['0.8', 'monthly'],
        'contact-us'      => ['0.8', 'monthly'],
        'schedule-meeting' => ['0.8', 'monthly'],
        'gallery'         => ['0.7', 'weekly'],
        'blog'            => ['0.8', 'daily'],
        'faq'             => ['0.7', 'monthly'],
        'near_by'         => ['0.6', 'monthly'],
        'help'            => ['0.5', 'monthly'],
        'privacy-policy'  => ['0.3', 'yearly'],
        'terms-condition' => ['0.3', 'yearly'],
    ];

    public function sitemap()
    {
        $xml = Cache::remember('seo.sitemap', 3600, function () {
            $urls = [];

            foreach (self::PAGES as $path => [$priority, $freq]) {
                $urls[] = ['loc' => url($path), 'priority' => $priority, 'changefreq' => $freq];
            }

            foreach ($this->servicePages() as $row) {
                $urls[] = [
                    'loc'        => url($row['model']->slug),
                    'lastmod'    => $row['model']->updated_at,
                    'priority'   => $row['priority'],
                    'changefreq' => 'monthly',
                    'image'      => $this->imageUrl($row['model']->thumbnail_img ?? null),
                    'title'      => $row['model']->name,
                ];
            }

            foreach (Blog::where('status', 1)->latest()->get() as $blog) {
                $urls[] = [
                    'loc'        => url('blog/' . $blog->slug),
                    'lastmod'    => $blog->updated_at ?? $blog->created_at,
                    'priority'   => '0.7',
                    'changefreq' => 'monthly',
                    'image'      => $this->imageUrl($blog->banner),
                    'title'      => $blog->name,
                ];
            }

            return view('seo.sitemap', compact('urls'))->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    public function feed()
    {
        $xml = Cache::remember('seo.feed', 3600, function () {
            $posts = Blog::where('status', 1)->latest()->take(30)->get();

            return view('seo.feed', compact('posts'))->render();
        });

        return response($xml, 200, ['Content-Type' => 'application/rss+xml; charset=UTF-8']);
    }

    public function llms()
    {
        $text = Cache::remember('seo.llms', 3600, function () {
            $setting = Setting::first();
            $categories = Category::with('subcategories')->where('status', 1)->orderBy('sort_order')->get();
            $posts = Blog::where('status', 1)->latest()->take(30)->get();

            $out = [];
            $out[] = '# ' . config('seo.brand');
            $out[] = '';
            $out[] = '> ' . Ui::siteDescription($setting);
            $out[] = '';
            $out[] = 'Leamsoft is a software engineering company serving businesses in Noida, Greater Noida, Ghaziabad, Delhi, Gurugram and Faridabad, and clients across India. '
                . 'Engagements are fixed-price or time-and-materials, delivered in two-week sprints with weekly demos; clients own all code and IP.';
            $out[] = '';

            $out[] = '## Services';
            $out[] = '';
            $out[] = '- [All services](' . url('services') . '): Overview of every service category.';
            foreach ($categories as $cat) {
                $out[] = '- [' . $cat->name . '](' . url($cat->slug) . '): ' . Ui::excerpt($cat->short_description, 160);
                foreach ($cat->subcategories as $sub) {
                    $out[] = '  - [' . $sub->name . '](' . url($sub->slug) . '): ' . Ui::excerpt($sub->short_description, 140);
                }
            }
            $out[] = '';

            if ($posts->count()) {
                $out[] = '## Blog';
                $out[] = '';
                foreach ($posts as $post) {
                    $out[] = '- [' . $post->name . '](' . url('blog/' . $post->slug) . '): ' . Ui::excerpt($post->short_description ?? $post->description, 160);
                }
                $out[] = '';
            }

            $out[] = '## Company';
            $out[] = '';
            $out[] = '- [About Leamsoft](' . url('about-us') . '): Who we are, values, tech stack and delivery process.';
            $out[] = '- [Our work](' . url('gallery') . '): Selected projects and services delivered.';
            $out[] = '- [FAQ](' . url('faq') . '): Pricing, timelines, IP ownership, security and engagement model.';
            $out[] = '- [Areas we serve](' . url('near_by') . '): Cities and localities across Delhi NCR.';
            $out[] = '- [Contact](' . url('contact-us') . '): Enquiry form and contact details.';
            $out[] = '- [Schedule a meeting](' . url('schedule-meeting') . '): Book a free 30-minute consultation (Google Meet, phone or in person).';
            $out[] = '';

            $out[] = '## Contact';
            $out[] = '';
            if (!empty($setting->email)) {
                $out[] = '- Email: ' . $setting->email;
            }
            if (!empty($setting->phone)) {
                $out[] = '- Phone / WhatsApp: ' . $setting->phone;
            }
            $addr = config('seo.address');
            if (!empty($addr['street'])) {
                $out[] = '- Office: ' . implode(', ', array_filter([$addr['street'], $addr['locality'], $addr['region'], $addr['postcode'], 'India']));
            }
            $out[] = '- Hours: Monday to Saturday, 9am – 7pm IST';
            $out[] = '';

            $out[] = '## Optional';
            $out[] = '';
            $out[] = '- [Sitemap](' . url('sitemap.xml') . ')';
            $out[] = '- [Blog RSS feed](' . url('feed.xml') . ')';
            $out[] = '- [Privacy policy](' . url('privacy-policy') . ')';
            $out[] = '- [Terms & conditions](' . url('terms-condition') . ')';

            return implode("\n", $out) . "\n";
        });

        return response($text, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    /**
     * Category, subcategory and service pages, deduplicated by slug in the
     * same order the router resolves them (category -> subcategory ->
     * service), so a slug shared by two records is listed once, for the page
     * visitors actually get.
     */
    private function servicePages(): array
    {
        $pages = [];
        $groups = [
            ['0.8', Category::where('status', 1)->orderBy('sort_order')->get()],
            ['0.7', Subcategory::where('status', 1)->orderBy('sort_order')->get()],
            ['0.6', Service::where('status', 1)->orderBy('sort_order')->get()],
        ];

        foreach ($groups as [$priority, $rows]) {
            foreach ($rows as $row) {
                if (empty($row->slug) || isset($pages[$row->slug])) {
                    continue;
                }
                $pages[$row->slug] = ['model' => $row, 'priority' => $priority];
            }
        }

        return array_values($pages);
    }

    private function imageUrl(?string $path): ?string
    {
        if (empty($path) || !file_exists(storage_path('app/public/' . $path))) {
            return null;
        }

        return url('storage/' . $path);
    }
}
