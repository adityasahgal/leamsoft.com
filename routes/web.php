<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\MeetingController as AdminMeetingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Machine-readable endpoints (built from the DB, cached)
Route::get('sitemap.xml', [SeoController::class, 'sitemap'])->name('sitemap');
Route::get('feed.xml', [SeoController::class, 'feed'])->name('feed');
Route::get('llms.txt', [SeoController::class, 'llms'])->name('llms');

Route::group(['middleware' => 'XssSanitizer'], function () {
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::get('/about-us', [MainController::class, 'about_us']);
    Route::get('/villas', [MainController::class, 'villas'])->name('villas');
    Route::get('/services', [MainController::class, 'villas'])->name('services');
    Route::get('/near_by', [MainController::class, 'near_by'])->name('near_by');
    Route::get('/privacy-policy', [MainController::class, 'privacy_policy']);
    Route::get('/contact-us', [MainController::class, 'contact_us']);
    Route::get('/schedule-meeting', [MeetingController::class, 'create'])->name('meeting.create');
    Route::post('/schedule-meeting', [MeetingController::class, 'store'])->name('meeting.store')->middleware('throttle:meeting');
    Route::get('/schedule-meeting/confirmed', [MeetingController::class, 'thanks'])->name('meeting.thanks');

    // Website chat widget
    Route::post('/chat/message', [ChatController::class, 'message'])->name('chat.message')->middleware('throttle:chat');
    Route::post('/chat/reset', [ChatController::class, 'reset'])->name('chat.reset');
    Route::post('/chat/lead', [ChatController::class, 'lead'])->name('chat.lead')->middleware('throttle:chat-lead');
    Route::post('showEnquiryModal', [MainController::class, 'showEnquiryModal']);
    Route::post('storeEnquiry', [MainController::class, 'storeEnquiry']);
    Route::post('enquiry', [MainController::class, 'enquiry']);
    Route::get('blog', [MainController::class, 'blog']);
    Route::get('blog/{slug}', [MainController::class, 'blog_details']);
    Route::get('/terms-condition', [MainController::class, 'termcondition']);
    Route::get('/faq', [MainController::class, 'faq']);
    Route::get('/help', [MainController::class, 'help']);
    Route::get('/gallery', [MainController::class, 'gallery']);

    Route::prefix('admin')->group(function () {
        Auth::routes();
        Route::group(['middleware' => 'auth'], function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');
            Route::get('/sitemap', [DashboardController::class, 'generate']);

            // Setting Routes
            Route::get('enquiry', [EnquiryController::class, 'index'])->name('enquiry.index');
            Route::post('enquiry/show', [EnquiryController::class, 'show'])->name('enquiry.show');

            // Meetings booked from /schedule-meeting
            Route::get('meetings', [AdminMeetingController::class, 'index'])->name('meetings.index');
            Route::post('meetings/show', [AdminMeetingController::class, 'show'])->name('meetings.show');
            Route::post('meetings/status', [AdminMeetingController::class, 'status'])->name('meetings.status');
            Route::post('meetings/new-link', [AdminMeetingController::class, 'newLink'])->name('meetings.newLink');

            // Setting Routes
            Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
            Route::post('setting/update', [SettingController::class, 'update'])->name('setting.update');

            // Banner Routes
            Route::get('banner', [BannerController::class, 'index'])->name('banner.index');
            Route::post('banner/store', [BannerController::class, 'store'])->name('banner.store');
            Route::post('banner/edit', [BannerController::class, 'edit'])->name('banner.edit');
            Route::post('banner/update', [BannerController::class, 'update'])->name('banner.update');
            Route::post('banner/status', [BannerController::class, 'status'])->name('banner.status');
            Route::post('banner/destroy', [BannerController::class, 'destroy'])->name('banner.destroy');

            // Service Route
            Route::get('service', [ServiceController::class, 'index'])->name('service.index');
            Route::get('service/create', [ServiceController::class, 'create'])->name('service.create');
            Route::post('service/store', [ServiceController::class, 'store'])->name('service.store');
            Route::get('service/edit/{id}', [ServiceController::class, 'edit'])->name('service.edit');
            Route::post('service/update', [ServiceController::class, 'update'])->name('service.update');
            Route::post('service/status', [ServiceController::class, 'status'])->name('service.status');
            Route::post('service/destroy', [ServiceController::class, 'destroy'])->name('service.destroy');

            // gallery Route
            Route::get('gallery', [GalleryController::class, 'index'])->name('gallery.index');
            Route::post('gallery/store', [GalleryController::class, 'store'])->name('gallery.store');
            Route::post('gallery/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
            Route::post('gallery/update', [GalleryController::class, 'update'])->name('gallery.update');
            Route::post('gallery/status', [GalleryController::class, 'status'])->name('gallery.status');
            Route::post('gallery/destroy', [GalleryController::class, 'destroy'])->name('gallery.destroy');

            // Blog Routes
            Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
            Route::post('blog/store', [BlogController::class, 'store'])->name('blog.store');
            Route::post('blog/edit', [BlogController::class, 'edit'])->name('blog.edit');
            Route::post('blog/update', [BlogController::class, 'update'])->name('blog.update');
            Route::post('blog/status', [BlogController::class, 'status'])->name('blog.status');
            Route::post('blog/destroy', [BlogController::class, 'destroy'])->name('blog.destroy');

            // Client Routes
            Route::get('client', [ClientController::class, 'index'])->name('client.index');
            Route::post('client/store', [ClientController::class, 'store'])->name('client.store');
            Route::post('client/edit', [ClientController::class, 'edit'])->name('client.edit');
            Route::post('client/update', [ClientController::class, 'update'])->name('client.update');
            Route::post('client/status', [ClientController::class, 'status'])->name('client.status');
            Route::post('client/destroy', [ClientController::class, 'destroy'])->name('client.destroy');

            // Users Route
            Route::get('users', [UserController::class, 'index'])->name('users.index');
            Route::get('users/create', [UserController::class, 'create'])->name('users.create');
            Route::post('users/store', [UserController::class, 'store'])->name('users.store');
            Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
            Route::post('users/update', [UserController::class, 'update'])->name('users.update');
            Route::post('users/status', [UserController::class, 'status'])->name('users.status');
            Route::post('users/destroy', [UserController::class, 'destroy'])->name('users.destroy');
            Route::get('users/userExports', [UserController::class, 'userExports'])->name('users.userExports');
            Route::get('users/change-password', [UserController::class, 'changePassword'])->name('users.changePassword');
            Route::post('users/change-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');

            //roles Routes
            Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
            Route::post('roles/store', [RoleController::class, 'store'])->name('roles.store');
            Route::post('roles/edit', [RoleController::class, 'edit'])->name('roles.edit');
            Route::post('roles/grant', [RoleController::class, 'grant'])->name('roles.grant');
            Route::post('roles/grantStore', [RoleController::class, 'grantStore'])->name('roles.grantStore');
            Route::post('roles/update', [RoleController::class, 'update'])->name('roles.update');
            Route::post('roles/destroy', [RoleController::class, 'destroy'])->name('roles.destroy');

            //Permission Routes
            Route::get('permission', [PermissionController::class, 'index'])->name('permission.index');
            Route::post('permission/store', [PermissionController::class, 'store'])->name('permission.store');
            Route::post('permission/edit', [PermissionController::class, 'edit'])->name('permission.edit');
            Route::post('permission/update', [PermissionController::class, 'update'])->name('permission.update');
            Route::post('permission/status', [PermissionController::class, 'status'])->name('permission.status');
            Route::post('permission/destroy', [PermissionController::class, 'destroy'])->name('permission.destroy');

            // Category Routes
            Route::get('category', [CategoryController::class, 'index'])->name('category.index');
            Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
            Route::post('category/edit', [CategoryController::class, 'edit'])->name('category.edit');
            Route::post('category/update', [CategoryController::class, 'update'])->name('category.update');
            Route::post('category/status', [CategoryController::class, 'status'])->name('category.status');
            Route::post('category/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');

            // Subcategory Routes
            Route::get('subcategory', [SubcategoryController::class, 'index'])->name('subcategory.index');
            Route::post('subcategory/store', [SubcategoryController::class, 'store'])->name('subcategory.store');
            Route::post('subcategory/edit', [SubcategoryController::class, 'edit'])->name('subcategory.edit');
            Route::post('subcategory/update', [SubcategoryController::class, 'update'])->name('subcategory.update');
            Route::post('subcategory/status', [SubcategoryController::class, 'status'])->name('subcategory.status');
            Route::post('subcategory/destroy', [SubcategoryController::class, 'destroy'])->name('subcategory.destroy');
        });
    });

    Route::get('{cateSlug}', [MainController::class, 'getCateSlug']);
});
