<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PromotionController as AdminPromotionController;
use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Partner\DashboardController as PartnerDashboardController;
use App\Http\Controllers\Pages\ServicesController;
use App\Http\Controllers\Pages\BookingController;
use App\Http\Controllers\Pages\ShopController;
use App\Http\Controllers\Pages\SubscriptionController;
use App\Http\Controllers\Pages\PacksController;

Route::get('/locale/{locale}', function (string $locale) {
    if (!in_array($locale, ['fr', 'en', 'ar'], true)) {
        abort(404);
    }

    session(['locale' => $locale]);
    app()->setLocale($locale);

    return redirect()->back();
})->name('locale.switch');

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServicesController::class, 'index'])->name('services');
Route::get('/packs', [PacksController::class, 'index'])->name('packs');
Route::get('/booking', [BookingController::class, 'index'])->name('booking');
Route::post('/booking', [BookingController::class, 'store'])->middleware('auth')->name('booking.store');
Route::get('/booking-cart', function () {
    $categories = \App\Models\Service::distinct()->pluck('category');
    return view('pages.booking-cart', compact('categories'));
})->middleware('auth')->name('booking.cart');
Route::get('/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions');
Route::post('/subscriptions/{subscription}/subscribe', [SubscriptionController::class, 'subscribe'])
    ->middleware('auth')
    ->name('subscriptions.subscribe');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::view('/partner', 'pages.partner')->name('partner.info');
Route::post('/cart/add/{product}', [ShopController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{product}', [ShopController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{product}', [ShopController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [ShopController::class, 'clear'])->name('cart.clear');
Route::post('/cart/checkout', [ShopController::class, 'checkout'])->middleware('auth')->name('cart.checkout');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Client routes
Route::get('/client/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');
Route::get('/client-dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard.alt');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('home');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('clients', AdminClientController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('services', AdminServiceController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    
    // Service Options Management
    Route::get('services/{service}/options', [\App\Http\Controllers\Admin\ServiceOptionController::class, 'index'])->name('services.options.index');
    Route::get('services/{service}/options/create', [\App\Http\Controllers\Admin\ServiceOptionController::class, 'create'])->name('services.options.create');
    Route::post('services/{service}/options', [\App\Http\Controllers\Admin\ServiceOptionController::class, 'store'])->name('services.options.store');
    Route::get('services/{service}/options/{option}/edit', [\App\Http\Controllers\Admin\ServiceOptionController::class, 'edit'])->name('services.options.edit');
    Route::put('services/{service}/options/{option}', [\App\Http\Controllers\Admin\ServiceOptionController::class, 'update'])->name('services.options.update');
    Route::delete('services/{service}/options/{option}', [\App\Http\Controllers\Admin\ServiceOptionController::class, 'destroy'])->name('services.options.destroy');
    
    Route::resource('bookings', AdminBookingController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('staff', AdminStaffController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('staff/{staff}/history', [AdminStaffController::class, 'history'])->name('staff.history');
    Route::resource('inventory', AdminInventoryController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('products', AdminProductController::class)->only(['index']);
    Route::post('products/{product}/stock', [AdminProductController::class, 'updateStock'])->name('products.stock');
    Route::resource('promotions', AdminPromotionController::class)->only(['index']);
    Route::resource('partners', AdminPartnerController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics');
});

// Partner routes
Route::middleware(['auth', 'partner'])->prefix('partner')->name('partner.')->group(function () {
    Route::get('/dashboard', [PartnerDashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings/create', [PartnerDashboardController::class, 'createBooking'])->name('bookings.create');
    Route::post('/bookings', [PartnerDashboardController::class, 'storeBooking'])->name('bookings.store');
});
