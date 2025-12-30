<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\OrderApiController;

use App\Http\Controllers\Api\ReviewApiController;
use App\Http\Controllers\Api\AddressApiController;
use App\Http\Controllers\Api\MessageApiController;

Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{id}', [ProductApiController::class, 'show']);

// Use only one POST route for order creation
Route::middleware('auth:sanctum')->post('/orders', [OrderApiController::class, 'store']);

use App\Http\Controllers\Api\CouponApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/apply-coupon', [CouponApiController::class, 'apply']);
    Route::get('/coupons', [CouponApiController::class, 'index']); // optional for showing active coupons

});

use App\Http\Controllers\Api\CategoryApiController;

Route::get('/categories', [CategoryApiController::class, 'index']);
Route::get('/products/category/{id}', [ProductApiController::class, 'getByCategory']);

use App\Http\Controllers\API\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user',    [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::middleware('auth:sanctum')->put('/user/update-password', [AuthController::class, 'updatePassword']);
Route::middleware('auth:sanctum')->get('/orders', [OrderApiController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reviews', [ReviewApiController::class, 'store']);
});

Route::get('/products/{id}/reviews', [ReviewApiController::class, 'productReviews']);

Route::middleware('auth:sanctum')->get('/my-reviews', [ReviewApiController::class, 'myReviews']);

//adresses 
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/addresses', [AddressApiController::class, 'index']);
    Route::post('/addresses', [AddressApiController::class, 'store']);
    Route::put('/addresses/{address}', [AddressApiController::class, 'update']);
    Route::delete('/addresses/{address}', [AddressApiController::class, 'destroy']);
});

use App\Http\Controllers\Api\FaqController;

Route::get('/faqs', [FaqController::class, 'index']);  
Route::get('/faqs/{id}', [FaqController::class, 'show']);  
Route::post('/faqs', [FaqController::class, 'store']);  


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders/{order_id}/messages', [MessageApiController::class, 'index']);
    Route::post('/messages', [MessageApiController::class, 'store']);
});


////banner 
use App\Http\Controllers\Api\BannerApiController;

Route::get('/banners/home', [BannerApiController::class, 'home']);
Route::get('/banners/campaigns', [BannerApiController::class, 'campaigns']);

////payment 

use App\Http\Controllers\Api\PaymentSettingApiController;

Route::get('/payment-settings', [PaymentSettingApiController::class, 'index']);

//faq

use App\Models\Page;

Route::get('/pages', function () {
    return Page::select('id', 'title', 'slug', 'content')->get();
});



//// live chat 


use App\Http\Controllers\Api\LiveChatApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/live-chat/start', [LiveChatApiController::class, 'start']); // ✅ Start new chat
    Route::post('/live-chat/send', [LiveChatApiController::class, 'store']); // ✅ Send message
    Route::get('/live-chat/fetchChat', [LiveChatApiController::class, 'fetchChat']); // ✅ Fetch active session chat only
    Route::get('/live-chat', [LiveChatApiController::class, 'index']); // (Optional) Fetch all chats (for admin maybe)
});




///resest password for users 
Route::post('/forgot-password', [App\Http\Controllers\API\ForgotPasswordController::class, 'sendResetLinkEmail']);

use App\Http\Controllers\Api\UserController;

Route::middleware('auth:sanctum')->put('/user/update', [UserController::class, 'update']);
////notificationssss
use App\Http\Controllers\Api\NotificationApiController;

Route::middleware('auth:sanctum')->get('/notifications', [NotificationApiController::class, 'index']);
Route::middleware('auth:sanctum')->get('/notifications/unread-count', function () {
    $count = \App\Models\Notification::where('user_id', auth()->id())
        ->where('is_read', false)
        ->count();

    return response()->json(['count' => $count]);
});

///user message 
use App\Http\Controllers\Api\UserMessageApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user-messages', [UserMessageApiController::class, 'index']);
    Route::post('/user-messages/{id}/read', [UserMessageApiController::class, 'markAsRead']);
});

Route::middleware('auth:sanctum')->get('/messages/unread-count', function () {
    $count = \App\Models\UserMessage::where('user_id', auth()->id())
                ->where('is_read', false)
                ->count();

    return response()->json(['count' => $count]);
});
////settinggg maintance 
use App\Http\Controllers\Api\SettingApiController;

use App\Models\GlobalSetting;
Route::get('/status', [SettingApiController::class, 'status']);
Route::get('/settings', function () {
    return response()->json([
        'maintenance_mode' => (bool) optional(GlobalSetting::first())->maintenance_mode
    ]);
});