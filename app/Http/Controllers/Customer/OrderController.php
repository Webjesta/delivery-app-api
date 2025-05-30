<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User; // Assuming your User model is in App\Models
use Illuminate\Http\Request; // Make sure Request is imported
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewOrderNotification; // Assuming you have a notification class for new orders

class OrderController extends Controller
{
    /**
     * Display a listing of the orders for the authenticated customer.
     *
     * @return JsonResponse
     */
  public function index(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) { // Line 30
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if (!$user->isCustomer()) { // Line 35
            return response()->json(['message' => 'Mtumiaji si mteja au profile ya mteja haikupatikana.'], 403);
        }

        // Line 39: This is the problematic line if $user->customer is null
        $orders = $user->customer
               ->orders()
               ->with('product.seller')     // ← load seller via product
               ->get();

        return response()->json(['data' => $orders]);
    }
    /**
     * Store a newly created order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        // Defensive checks for authentication and customer role.
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        // Use the isCustomer() method from the User model.
        if (!$user->isCustomer()) {
            return response()->json(['message' => 'Mtumiaji si mteja au profile ya mteja haikupatikana.'], 403);
        }

        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        // Create the order associated with the authenticated customer's profile.
        $order = $user->customer->orders()->create([
            'product_id' => $data['product_id'],
            'quantity'   => $data['quantity'],
            'status'     => 'pending', // Default status for new orders
        ]);

         // notify the seller
        $order->product->seller->notify(new NewOrderNotification($order));

        return response()->json([
            'message' => 'Oda imewekwa',
            'data'    => $order->load('product'), // Load the product relationship for the response
        ], 201);
    }

    /**
     * Display the specified order.
     *
     * @param  int  $id The ID of the order to display.
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        // Defensive checks for authentication and customer role.
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        // Use the isCustomer() method from the User model.
        if (!$user->isCustomer()) {
            return response()->json(['message' => 'Mtumiaji si mteja au profile ya mteja haikupatikana.'], 403);
        }

        // Find the order by ID, ensuring it belongs to the authenticated customer's profile.
        $order = $user->customer
                      ->orders()
                    ->with('product.seller')     // ← load seller via product
                      ->findOrFail($id); // firstOrFail() will automatically throw a 404 if not found or not owned by customer

        return response()->json(['data' => $order]);
    }
}
