<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Auth::user()->seller->products;
        return response()->json(['data'=>$products]);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Auth::user()->seller
                         ->products()
                         ->create($request->validated());

        return response()->json([
            'message'=>'Product created',
            'data'   =>$product
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $product = Auth::user()->seller
                          ->products()
                          ->findOrFail($id);

        return response()->json(['data'=>$product]);
    }

    public function update(StoreProductRequest $request, $id): JsonResponse
    {
        $product = Auth::user()->seller
                          ->products()
                          ->findOrFail($id);

        $product->update($request->validated());

        return response()->json([
            'message'=>'Product updated',
            'data'   =>$product
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $product = Auth::user()->seller
                          ->products()
                          ->findOrFail($id);

        $product->delete();

        return response()->json(['message'=>'Product deleted']);
    }
}
