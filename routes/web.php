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
use App\Http\Controllers\PagarMeWebhookController;

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
    Route::post('settings/test-pagarme-connection', [AdminSettingController::class, 'testPagarMeConnection'])->name('settings.test-pagarme-connection');
    
    // Client Projects Management
    Route::resource('client-projects', \App\Http\Controllers\Admin\ClientProjectController::class);
    Route::put('client-projects/{clientProject}/progress', [\App\Http\Controllers\Admin\ClientProjectController::class, 'updateProgress'])->name('client-projects.update-progress');
    
    // Invoices Management
    Route::resource('invoices', \App\Http\Controllers\Admin\InvoiceController::class);
    Route::post('invoices/{invoice}/mark-as-paid', [\App\Http\Controllers\Admin\InvoiceController::class, 'markAsPaid'])->name('invoices.mark-as-paid');
    Route::get('ajax/client-projects', [\App\Http\Controllers\Admin\InvoiceController::class, 'getClientProjects'])->name('ajax.client-projects');
    
    // PagarMe Integration for Invoices
    Route::post('invoices/{invoice}/pagarme/generate', [\App\Http\Controllers\Admin\InvoiceController::class, 'generatePagarMeCharge'])->name('invoices.pagarme.generate');
    Route::post('invoices/{invoice}/pagarme/auto-charge/enable', [\App\Http\Controllers\Admin\InvoiceController::class, 'enableAutoCharge'])->name('invoices.pagarme.auto-charge.enable');
    Route::post('invoices/{invoice}/pagarme/auto-charge/disable', [\App\Http\Controllers\Admin\InvoiceController::class, 'disableAutoCharge'])->name('invoices.pagarme.auto-charge.disable');
    Route::post('invoices/{invoice}/pagarme/status', [\App\Http\Controllers\Admin\InvoiceController::class, 'checkPagarMeStatus'])->name('invoices.pagarme.status');
    Route::post('invoices/{invoice}/pagarme/cancel', [\App\Http\Controllers\Admin\InvoiceController::class, 'cancelPagarMeCharge'])->name('invoices.pagarme.cancel');
    
    // Support Tickets Management
    Route::resource('support-tickets', \App\Http\Controllers\Admin\SupportTicketController::class)->only(['index', 'show', 'destroy']);
    Route::post('support-tickets/{supportTicket}/assign', [\App\Http\Controllers\Admin\SupportTicketController::class, 'assign'])->name('support-tickets.assign');
    Route::put('support-tickets/{supportTicket}/status', [\App\Http\Controllers\Admin\SupportTicketController::class, 'updateStatus'])->name('support-tickets.update-status');
    Route::put('support-tickets/{supportTicket}/priority', [\App\Http\Controllers\Admin\SupportTicketController::class, 'updatePriority'])->name('support-tickets.update-priority');
    Route::post('support-tickets/{supportTicket}/reply', [\App\Http\Controllers\Admin\SupportTicketController::class, 'reply'])->name('support-tickets.reply');
    Route::post('support-tickets/{supportTicket}/resolve', [\App\Http\Controllers\Admin\SupportTicketController::class, 'markAsResolved'])->name('support-tickets.resolve');
    Route::post('support-tickets/{supportTicket}/mark-as-resolved', [\App\Http\Controllers\Admin\SupportTicketController::class, 'markAsResolved'])->name('support-tickets.mark-as-resolved');
    Route::post('support-tickets/{supportTicket}/close', [\App\Http\Controllers\Admin\SupportTicketController::class, 'close'])->name('support-tickets.close');
    Route::post('support-tickets/{supportTicket}/reopen', [\App\Http\Controllers\Admin\SupportTicketController::class, 'reopen'])->name('support-tickets.reopen');
    Route::get('support-analytics', [\App\Http\Controllers\Admin\SupportTicketController::class, 'analytics'])->name('support-tickets.analytics');
    
    // Pages Management (será implementado depois)
    // Route::resource('pages', AdminPageController::class);
    
    // SEO Management
    Route::get('seo', [AdminSettingController::class, 'seoIndex'])->name('seo.index');
    Route::post('seo/sitemap/generate', [AdminSettingController::class, 'generateSitemap'])->name('seo.sitemap.generate');
    Route::post('seo/robots/update', [AdminSettingController::class, 'updateRobots'])->name('seo.robots.update');
    Route::post('seo/robots/reset', [AdminSettingController::class, 'resetRobots'])->name('seo.robots.reset');

    // Profile Management
    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('profile/validate-document', [\App\Http\Controllers\Admin\ProfileController::class, 'validateDocument'])->name('profile.validate-document');
    Route::post('profile/avatar', [\App\Http\Controllers\Admin\ProfileController::class, 'uploadAvatar'])->name('profile.upload-avatar');
    Route::delete('profile/avatar', [\App\Http\Controllers\Admin\ProfileController::class, 'removeAvatar'])->name('profile.remove-avatar');
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
    Route::post('/support/{ticket}/reply', [\App\Http\Controllers\Client\SupportController::class, 'reply'])->name('support.reply');
    
    // Profile
    Route::get('/profile', [\App\Http\Controllers\Client\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [\App\Http\Controllers\Client\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Client\ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/validate-document', [\App\Http\Controllers\Client\ProfileController::class, 'validateDocument'])->name('profile.validate-document');
    Route::post('/profile/avatar', [\App\Http\Controllers\Client\ProfileController::class, 'uploadAvatar'])->name('profile.upload-avatar');
    Route::delete('/profile/avatar', [\App\Http\Controllers\Client\ProfileController::class, 'removeAvatar'])->name('profile.remove-avatar');
});

// PagarMe Webhook Routes (sem middleware de autenticação)
Route::prefix('pagarme')->name('pagarme.')->group(function () {
    Route::post('/webhook', [\App\Http\Controllers\PagarMeWebhookController::class, 'receive'])->name('webhook');
    Route::post('/webhook/test', [\App\Http\Controllers\PagarMeWebhookController::class, 'test'])->name('webhook.test');
});

// Auth Routes (Laravel/UI)
Auth::routes();
// Static Pages (deve ficar por último para não conflitar)
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');

// Public SEO Routes
Route::get('sitemap.xml', function () {
    $sitemapPath = public_path('sitemap.xml');
    
    if (!file_exists($sitemapPath)) {
        abort(404);
    }
    
    return response(file_get_contents($sitemapPath), 200, [
        'Content-Type' => 'application/xml'
    ]);
});

Route::get('robots.txt', function () {
    $robotsPath = public_path('robots.txt');
    
    if (!file_exists($robotsPath)) {
        $baseUrl = config('app.url');
        $defaultContent = "User-agent: *\nDisallow: /admin/\nDisallow: /client/\nAllow: /\n\nSitemap: {$baseUrl}/sitemap.xml\n";
        return response($defaultContent, 200, ['Content-Type' => 'text/plain']);
    }
    
    return response(file_get_contents($robotsPath), 200, [
        'Content-Type' => 'text/plain'
    ]);
});
