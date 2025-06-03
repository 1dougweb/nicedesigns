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
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
// About Route
Route::get('/sobre', function () {
    return view('about');
})->name('about');
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
// Admin Routes (Only for users with admin role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
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
    // Settings Management
    Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');
    Route::post('settings/test-email', [AdminSettingController::class, 'testEmail'])->name('settings.test-email');
    Route::post('settings/clear-cache', [AdminSettingController::class, 'clearCache'])->name('settings.clear-cache');
    
    // Pages Management (será implementado depois)
    // Route::resource('pages', AdminPageController::class);
});

// Client Routes (Only for users with client role)
Route::middleware(['auth', 'client'])->prefix('client')->name('client.')->group(function () {
    // Dashboard
    Route::get('/', [ClientDashboardController::class, 'index'])->name('dashboard');
    
    // Projects
    Route::get('/projects', [\App\Http\Controllers\Client\ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [\App\Http\Controllers\Client\ProjectController::class, 'show'])->name('projects.show');
    
    // Invoices
    Route::get('/invoices', [\App\Http\Controllers\Client\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [\App\Http\Controllers\Client\InvoiceController::class, 'show'])->name('invoices.show');
    
    // Support Tickets
    Route::get('/support', [\App\Http\Controllers\Client\SupportController::class, 'index'])->name('support.index');
    Route::get('/support/create', [\App\Http\Controllers\Client\SupportController::class, 'create'])->name('support.create');
    Route::post('/support', [\App\Http\Controllers\Client\SupportController::class, 'store'])->name('support.store');
    Route::get('/support/{ticket}', [\App\Http\Controllers\Client\SupportController::class, 'show'])->name('support.show');
    
    // Profile
    Route::get('/profile', [\App\Http\Controllers\Client\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [\App\Http\Controllers\Client\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Client\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/validate-document', [\App\Http\Controllers\Client\ProfileController::class, 'validateDocument'])->name('profile.validate-document');
    Route::post('/profile/avatar', [\App\Http\Controllers\Client\ProfileController::class, 'uploadAvatar'])->name('profile.upload-avatar');
    Route::delete('/profile/avatar', [\App\Http\Controllers\Client\ProfileController::class, 'removeAvatar'])->name('profile.remove-avatar');
});

// Auth Routes (Laravel/UI)
Auth::routes();
// Static Pages (deve ficar por último para não conflitar)
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
