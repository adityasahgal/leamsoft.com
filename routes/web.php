<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'XssSanitizer'], function () {
    Route::get('/', [MainController::class, 'index'])->name('index');
    Route::get('/about-us', [MainController::class, 'about_us']);
    Route::get('/villas', [MainController::class, 'villas'])->name('villas');
    Route::get('/near_by', [MainController::class, 'near_by'])->name('near_by');
    Route::get('/privacy-policy', [MainController::class, 'privacy_policy']);
    Route::get('/contact-us', [MainController::class, 'contact_us']);
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
        });
    });

    Route::get('{cateSlug}', [MainController::class, 'getCateSlug']);
});
