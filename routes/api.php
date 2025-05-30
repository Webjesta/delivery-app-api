<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\OrderController   as SellerOrderController;
use App\Http\Controllers\Customer\BrowseController;
use App\Http\Controllers\Customer\OrderController   as CustomerOrderController;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your delivery app.
| These routes are loaded by the RouteServiceProvider within a group
| which is assigned the "api" middleware group and the /api prefix.
|
*/

// Public: registration and login routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);

// Protected routes (require Sanctum authentication token)
Route::middleware('auth:sanctum')->group(function () {

    // Fetch current user’s notifications
    Route::get('notifications', function(Request $req) {
        $user = $req->user();

        if ($user->role === 'seller') {
            // fetch notifications stored on the Seller model
            return response()->json($user->seller->notifications);
        }

        // otherwise assume customer
        return response()->json($user->customer->notifications);
    });

    // Mark a notification as read
    Route::patch('notifications/{id}/read', function(Request $req, $id) {
        $notification = $req->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return response()->json(['message'=>'Marked as read']);
    });

    // Logout route for authenticated users
    Route::post('logout', [AuthController::class, 'logout']);

    // Seller routes (only accessible by authenticated users)
    // These routes are prefixed with 'seller'.
    Route::prefix('seller')
         // ->middleware('is.seller') // Kipengele cha 'is.seller' kimeondolewa
         ->group(function () {
            // RESTful API resource for products (index, store, show, update, destroy)
            Route::apiResource('products', SellerProductController::class);

            // Routes for sellers to view and update orders related to their products
            Route::get('orders',          [SellerOrderController::class, 'index']);
            Route::patch('orders/{order}', [SellerOrderController::class, 'update']);
         });

    // Customer routes (only accessible by authenticated users)
    // These routes are prefixed with 'customer'.
    Route::prefix('customer')
         // ->middleware('is.customer') // Kipengele cha 'is.customer' kimeondolewa
         ->group(function () {
            // Route for customers to browse available products
            Route::get('browse', [BrowseController::class, 'index']);

            // Routes for customers to place and view their own orders
            Route::post('orders',    [CustomerOrderController::class, 'store']);
            Route::get('orders',    [CustomerOrderController::class, 'index']);
            Route::get('orders/{id}', [CustomerOrderController::class, 'show']);
         });

});
