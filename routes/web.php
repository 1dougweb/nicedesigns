<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Blog Routes
Route::prefix('blog')->name('posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/categoria/{slug}', [PostController::class, 'category'])->name('category');
    Route::get('/{slug}', [PostController::class, 'show'])->name('show');
});

// Portfolio Routes
Route::prefix('portfolio')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/{slug}', [ProjectController::class, 'show'])->name('show');
});

// Contact Routes
Route::get('/contato', [ContactController::class, 'index'])->name('contact');
Route::post('/contato', [ContactController::class, 'store'])->name('contact.store');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Posts Management
    Route::resource('posts', AdminPostController::class);
    
    // Projects Management
    Route::resource('projects', AdminProjectController::class);
    
    // Categories Management
    Route::resource('categories', AdminCategoryController::class);
    
    // Contacts Management
    Route::resource('contacts', AdminContactController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::patch('contacts/{contact}/mark-as-read', [AdminContactController::class, 'markAsRead'])->name('contacts.mark-as-read');
    Route::patch('contacts/{contact}/mark-as-completed', [AdminContactController::class, 'markAsCompleted'])->name('contacts.mark-as-completed');
    
    // Pages Management (será implementado depois)
    // Route::resource('pages', AdminPageController::class);
    
    // Settings (será implementado depois)
    // Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    // Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
});

// Auth Routes (Laravel/UI)
Auth::routes();

// Static Pages (deve ficar por último para não conflitar)
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
