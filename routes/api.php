<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\MiscellaneousController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CardController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['auth:sanctum']], function () {


    Route::post('cart/add', [CartController::class, 'addToCart']);
    Route::post('cart/update', [CartController::class, 'updateCart']);
    Route::get('/cart', [CartController::class, 'viewCart']);
    Route::GET('/cart/clear', [CartController::class, 'clearCart']);
    Route::GET('/cart/remove-cart-item', [CartController::class, 'removeCartItem']);


    Route::controller(AuthController::class)->group(function () {
        Route::PUT('update-fcm-token', 'updateFcmToken');
        Route::PUT('update-user-location', 'updateUserLocation');
        Route::POST('change-password', 'changePassword');
        Route::POST('logout', 'logout');
    });
    
    Route::controller(ServiceController::class)->group(function () {
        Route::GET('categories', 'categories');
        Route::GET('services', 'services');
        Route::POST('add-service', 'addService');
        Route::POST('update-service', 'updateService');
        Route::GET('service-detail', 'serviceDetail');
    });

    Route::controller(MiscellaneousController::class)->group(function () {
        Route::POST('support', 'support');
    });

    Route::controller(UserController::class)->group(function () {
        Route::POST('add-review', 'addReview');
        Route::GET('category-wise-services', 'categoryWiseServices');
        Route::GET('user-dashboard', 'dashboard');
        Route::GET('service-detail', 'serviceDetail');
        Route::GET('reviews', 'reviews');
    });

    Route::controller(CardController::class)->group(function () {
        Route::post('add-card', 'add');
        Route::GET('retreive-cards', 'retrieveCards');
        Route::POST('set-default-card', 'makeDefaultCard');
        Route::POST('delete-card', 'deleteCard');
    });
    
});


Route::prefix('auth')->group(function() {
    Route::controller(AuthController::class)->group(function () {
        Route::POST('login', 'login');
        Route::POST('register', 'register');
        Route::POST('verify-token', 'verifyToken');
        Route::POST('resend-otp-token', 'resendOtpToken');
        Route::POST('forgot-password', 'forgotPassword');
        Route::PUT('set-password', 'setPassword');
        Route::GET('unauthenticated', 'unauthenticatedUser')->name('api.unauthenticated');
    });
});
