<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MediaCategoryController;
use App\Http\Controllers\Admin\PhotoGalleryController;
use App\Http\Controllers\Admin\VideoGalleryController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\CommitteeContentController;
use App\Http\Controllers\Admin\NewsPageController;

// Media Categories
Route::resource('media-categories', MediaCategoryController::class);

// Photo Gallery
Route::resource('photo-gallery', PhotoGalleryController::class);

// Video Gallery
Route::resource('video-gallery', VideoGalleryController::class);

// Memberships
Route::resource('memberships', MembershipController::class);
Route::post('memberships/{membership}/approve', [MembershipController::class, 'approve'])->name('memberships.approve');
Route::post('memberships/{membership}/reject', [MembershipController::class, 'reject'])->name('memberships.reject');

// About Page
Route::get('about', [AboutController::class, 'index'])->name('about.index');
Route::get('about/edit', [AboutController::class, 'edit'])->name('about.edit');
Route::put('about', [AboutController::class, 'update'])->name('about.update');

// Committee Page
Route::get('committee', [CommitteeContentController::class, 'index'])->name('committee.index');
Route::get('committee/edit', [CommitteeContentController::class, 'edit'])->name('committee.edit');
Route::put('committee', [CommitteeContentController::class, 'update'])->name('committee.update');

// News Page
Route::get('news-page', [NewsPageController::class, 'index'])->name('news-page.index');
Route::put('news-page', [NewsPageController::class, 'update'])->name('news-page.update');

// Press Release Page 
Route::get('press-release-page', [PressReleaseController::class, 'index'])->name('press-release-page.index');