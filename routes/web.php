<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\PhotoGalleryController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\EconomicActivityController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GrievanceController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\LanguageController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lang', [LanguageController::class, 'switchLang'])->name('lang.switch');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/committee', [CommitteeController::class, 'index'])->name('committee');
Route::get('/photo-gallery', [PhotoGalleryController::class, 'index'])->name('photo-gallery');
Route::get('/video-gallery', [App\Http\Controllers\VideoGalleryController::class, 'index'])->name('video-gallery');
Route::get('/publications', [PublicationController::class, 'index'])->name('publications');
Route::get('/publications/{publication}/download', [PublicationController::class, 'download'])->name('publications.download');
Route::get('/economic-activity', [EconomicActivityController::class, 'index'])->name('economic-activity');
Route::get('/economic-activity/{publication}/download', [EconomicActivityController::class, 'download'])->name('economic-activity.download');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/grievance', [ComplaintController::class, 'index'])->name('grievance.index');
Route::post('/grievance', [ComplaintController::class, 'store'])->name('grievance.store');
Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news');
Route::get('/news/{slug}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');
Route::get('/press-release', [App\Http\Controllers\PressReleaseController::class, 'index'])->name('press-release');
Route::get('/press-release/{slug}', [App\Http\Controllers\PressReleaseController::class, 'show'])->name('press-release.show');
Route::get('/press-release/{slug}/download', [App\Http\Controllers\PressReleaseController::class, 'download'])->name('press-release.download');
Route::get('/notice', [App\Http\Controllers\NoticeController::class, 'index'])->name('notice');
Route::get('/notice/{slug}', [App\Http\Controllers\NoticeController::class, 'show'])->name('notice.show');
Route::get('/notice/{slug}/download', [App\Http\Controllers\NoticeController::class, 'download'])->name('notice.download');
Route::get('/membership', [App\Http\Controllers\MembershipController::class, 'index'])->name('membership.index');
Route::post('/membership', [App\Http\Controllers\MembershipController::class, 'store'])->name('membership.store');
Route::post('/membership/check-status', [App\Http\Controllers\MembershipController::class, 'checkStatus'])->name('membership.check-status');

// SEO Routes
Route::get('/robots.txt', function () {
    $content = \App\Helpers\SettingsHelper::getRobotsTxt();
    return response($content)->header('Content-Type', 'text/plain');
});

Route::get('/sitemap.xml', function () {
    // Basic sitemap - you can expand this
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $sitemap .= '<url><loc>' . url('/') . '</loc><changefreq>daily</changefreq><priority>1.0</priority></url>';
    $sitemap .= '<url><loc>' . url('/about') . '</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>';
    $sitemap .= '<url><loc>' . url('/committee') . '</loc><changefreq>monthly</changefreq><priority>0.8</priority></url>';
    $sitemap .= '<url><loc>' . url('/contact') . '</loc><changefreq>monthly</changefreq><priority>0.7</priority></url>';
    $sitemap .= '<url><loc>' . url('/news') . '</loc><changefreq>daily</changefreq><priority>0.9</priority></url>';
    $sitemap .= '</urlset>';
    
    return response($sitemap)->header('Content-Type', 'application/xml');
});
// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [App\Http\Controllers\AdminController::class, 'login'])->name('login');
    Route::post('/login', [App\Http\Controllers\AdminController::class, 'authenticate'])->name('authenticate');
    Route::post('/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('logout');
    
    // Protected Admin Routes
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
        Route::resource('news', App\Http\Controllers\Admin\NewsController::class);
        Route::post('/news/bulk-action', [App\Http\Controllers\Admin\NewsController::class, 'bulkAction'])->name('news.bulk-action');
        Route::resource('news-categories', App\Http\Controllers\Admin\NewsCategoryController::class);
        Route::post('/news-categories/bulk-action', [App\Http\Controllers\Admin\NewsCategoryController::class, 'bulkAction'])->name('news-categories.bulk-action');
        Route::resource('press-releases', App\Http\Controllers\Admin\PressReleaseController::class);
        Route::post('/press-releases/bulk-action', [App\Http\Controllers\Admin\PressReleaseController::class, 'bulkAction'])->name('press-releases.bulk-action');
        Route::get('/press-releases/{press_release}/download', [App\Http\Controllers\Admin\PressReleaseController::class, 'download'])->name('press-releases.download');
        Route::resource('notices', App\Http\Controllers\Admin\NoticeController::class);
        Route::post('/notices/bulk-action', [App\Http\Controllers\Admin\NoticeController::class, 'bulkAction'])->name('notices.bulk-action');
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::patch('/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::resource('media', App\Http\Controllers\Admin\MediaController::class);
        Route::post('/media/bulk-delete', [App\Http\Controllers\Admin\MediaController::class, 'bulkDelete'])->name('media.bulk-delete');
        Route::get('/media/{media}/download', [App\Http\Controllers\Admin\MediaController::class, 'download'])->name('media.download');
        
        // Media Categories
        Route::resource('media-categories', App\Http\Controllers\Admin\MediaCategoryController::class);
        
        // Photo Gallery
        Route::resource('photo-gallery', App\Http\Controllers\Admin\PhotoGalleryController::class);
        
        // Video Gallery
        Route::resource('video-gallery', App\Http\Controllers\Admin\VideoGalleryController::class);
        
        // Memberships
        Route::resource('memberships', App\Http\Controllers\Admin\MembershipController::class);
        Route::post('/memberships/{membership}/approve', [App\Http\Controllers\Admin\MembershipController::class, 'approve'])->name('memberships.approve');
        Route::post('/memberships/{membership}/reject', [App\Http\Controllers\Admin\MembershipController::class, 'reject'])->name('memberships.reject');
        
        // Membership Categories
        Route::resource('membership-categories', App\Http\Controllers\Admin\MembershipCategoryController::class);
        
        // About Page Management
        Route::get('about-page', [App\Http\Controllers\Admin\AboutController::class, 'index'])->name('about.index');
        Route::get('about-page/edit', [App\Http\Controllers\Admin\AboutController::class, 'edit'])->name('about.edit');
        Route::put('about-page', [App\Http\Controllers\Admin\AboutController::class, 'update'])->name('about.update');
        Route::post('about-page/update-section', [App\Http\Controllers\Admin\AboutController::class, 'updateSection'])->name('about.update-section');
        
        // Committee Page Management
        Route::get('committee-page', [App\Http\Controllers\Admin\CommitteeContentController::class, 'index'])->name('committee.index');
        Route::get('committee-page/edit', [App\Http\Controllers\Admin\CommitteeContentController::class, 'edit'])->name('committee.edit');
        Route::put('committee-page', [App\Http\Controllers\Admin\CommitteeContentController::class, 'update'])->name('committee.update');
        Route::post('committee-page/update-section', [App\Http\Controllers\Admin\CommitteeContentController::class, 'updateSection'])->name('committee.update-section');
        
        // Publications & Economic Activities Management
        Route::resource('publications', App\Http\Controllers\Admin\PublicationController::class);
        Route::post('publications/bulk-action', [App\Http\Controllers\Admin\PublicationController::class, 'bulkAction'])->name('publications.bulk-action');
        Route::get('publications/{publication}/download', [App\Http\Controllers\Admin\PublicationController::class, 'download'])->name('publications.download');
        
        // Complaints Management
        Route::resource('complaints', App\Http\Controllers\Admin\ComplaintController::class)->except(['create', 'store', 'edit']);
        Route::post('complaints/bulk-update', [App\Http\Controllers\Admin\ComplaintController::class, 'bulkUpdate'])->name('complaints.bulk-update');
        
        // Contacts Management
        Route::resource('contacts', App\Http\Controllers\Admin\ContactController::class)->except(['create', 'store', 'edit']);
        Route::post('contacts/bulk-update', [App\Http\Controllers\Admin\ContactController::class, 'bulkUpdate'])->name('contacts.bulk-update');
        
        // Site Settings Management
        Route::get('settings', [App\Http\Controllers\Admin\SiteSettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [App\Http\Controllers\Admin\SiteSettingController::class, 'update'])->name('settings.update');
        Route::post('settings/seed', [App\Http\Controllers\Admin\SiteSettingController::class, 'seed'])->name('settings.seed');
        
        // Contact Page Management
        Route::get('contact-page', [App\Http\Controllers\Admin\ContactContentController::class, 'index'])->name('contact-page.index');
        Route::get('contact-page/edit', [App\Http\Controllers\Admin\ContactContentController::class, 'edit'])->name('contact-page.edit');
        Route::put('contact-page', [App\Http\Controllers\Admin\ContactContentController::class, 'update'])->name('contact-page.update');
        

        
        // Page Titles Management
        Route::get('page-titles', [App\Http\Controllers\Admin\PageTitleController::class, 'index'])->name('page-titles.index');
        Route::put('page-titles', [App\Http\Controllers\Admin\PageTitleController::class, 'update'])->name('page-titles.update');
        
        // News Page Management
        Route::get('news-page', [App\Http\Controllers\Admin\NewsPageController::class, 'index'])->name('news-page.index');
        Route::put('news-page', [App\Http\Controllers\Admin\NewsPageController::class, 'update'])->name('news-page.update');
        
        // Notice Page Management
        Route::get('notice-page', [App\Http\Controllers\Admin\NoticePageController::class, 'index'])->name('notice-page.index');
        Route::put('notice-page', [App\Http\Controllers\Admin\NoticePageController::class, 'update'])->name('notice-page.update');
        
        // Press Release Page Management
        Route::get('press-release-page', [App\Http\Controllers\Admin\PressReleasePageController::class, 'index'])->name('press-release-page.index');
        Route::put('press-release-page', [App\Http\Controllers\Admin\PressReleasePageController::class, 'update'])->name('press-release-page.update');

        // Photo Gallery Page Management
        Route::get('photo-gallery-page', [App\Http\Controllers\Admin\PhotoGalleryPageController::class, 'index'])->name('photo-gallery-page.index');
        Route::put('photo-gallery-page', [App\Http\Controllers\Admin\PhotoGalleryPageController::class, 'update'])->name('photo-gallery-page.update');

        // Video Gallery Page Management
        Route::get('video-gallery-page', [App\Http\Controllers\Admin\VideoGalleryPageController::class, 'index'])->name('video-gallery-page.index');
        Route::put('video-gallery-page', [App\Http\Controllers\Admin\VideoGalleryPageController::class, 'update'])->name('video-gallery-page.update');

        // Publication Page Management
        Route::get('publication-page', [App\Http\Controllers\Admin\PublicationPageController::class, 'index'])->name('publication-page.index');
        Route::put('publication-page', [App\Http\Controllers\Admin\PublicationPageController::class, 'update'])->name('publication-page.update');

        // Economic Activity Page Management
        Route::get('economic-activity-page', [App\Http\Controllers\Admin\EconomicActivityPageController::class, 'index'])->name('economic-activity-page.index');
        Route::put('economic-activity-page', [App\Http\Controllers\Admin\EconomicActivityPageController::class, 'update'])->name('economic-activity-page.update');

        // Membership Page Management
        Route::get('membership-page', [App\Http\Controllers\Admin\MembershipPageController::class, 'index'])->name('membership-page.index');
        Route::put('membership-page', [App\Http\Controllers\Admin\MembershipPageController::class, 'update'])->name('membership-page.update');

        // Grievance Page Management
        Route::get('grievance-page', [App\Http\Controllers\Admin\GrievancePageController::class, 'index'])->name('grievance-page.index');
        Route::put('grievance-page', [App\Http\Controllers\Admin\GrievancePageController::class, 'update'])->name('grievance-page.update');


    });
});
