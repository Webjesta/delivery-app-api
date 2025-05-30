<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class BrowseController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::where('stock','>','0')->get();
        return response()->json(['data'=>$products]);
    }
}
