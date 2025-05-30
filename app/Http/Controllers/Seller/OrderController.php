<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use App\Models\User; // Assuming your User model is in App\Models
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderStatusChangedNotification; // Assuming you have a notification class for order status changes

class OrderController extends Controller
{
    /**
     * Display a listing of the orders for the authenticated seller.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        /** @var User $user */ // PHPDoc to hint the type of the authenticated user
        $user = Auth::user();
        $seller = $user->seller; // Now Intelephense knows $user is a User model

        $orders = Order::with(['product', 'customer'])
            ->whereHas('product', fn($q) => $q->where('seller_id', $seller->id))
            ->get();

        return response()->json(['data' => $orders]);
    }

    /**
     * Update the status of a specific order for the authenticated seller.
     *
     * @param UpdateOrderStatusRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateOrderStatusRequest $request, $id): JsonResponse
    {
        /** @var User $user */ // PHPDoc to hint the type of the authenticated user
        $user = Auth::user();
        $seller = $user->seller; // Now Intelephense knows $user is a User model

        $order = Order::where('id', $id)
            ->whereHas('product', fn($q) => $q->where('seller_id', $seller->id))
            ->firstOrFail();

        $order->status = $request->validated()['status'];
        $order->save();

        // notify the customer
        $order->customer->notify(new OrderStatusChangedNotification($order));

        return response()->json([
            'message' => 'Order status updated',
            'data'    => $order
        ]);
    }
}
