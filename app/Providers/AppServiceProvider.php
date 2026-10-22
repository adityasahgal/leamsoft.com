<?php

namespace App\Providers;

use App\Http\Controllers\SeoController;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Client;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** Cache key for the header/footer data shared by every public page. */
    public const SHARED_KEY = 'site.shared';

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        // Site settings + service categories feed the header, footer and
        // contact blocks on every public page. Cached so a page view costs
        // no extra queries; any admin change below flushes it.
        View::composer(['layouts.master', 'frontend.*', 'layouts.partials.*', 'errors::*', 'errors.*', 'layouts.auth', 'auth.*'], function ($view) {
            static $shared;

            $shared ??= Cache::remember(self::SHARED_KEY, 3600, fn () => [
                'genSetting'    => Setting::first(),
                'navCategories' => Category::with('subcategories')
                    ->where('status', 1)
                    ->orderBy('sort_order')
                    ->take(6)
                    ->get(),
            ]);

            $view->with($shared);
        });

        foreach ([Setting::class, Category::class, Subcategory::class, Service::class, Blog::class, Client::class] as $model) {
            $model::saved(fn () => self::flushSiteCaches());
            $model::deleted(fn () => self::flushSiteCaches());
        }
    }

    /**
     * Drop every cached rendering of site content (shared layout data,
     * sitemap, RSS, llms.txt) so the next request rebuilds it.
     */
    public static function flushSiteCaches(): void
    {
        Cache::forget(self::SHARED_KEY);
        foreach (SeoController::CACHE_KEYS as $key) {
            Cache::forget($key);
        }
    }
}
