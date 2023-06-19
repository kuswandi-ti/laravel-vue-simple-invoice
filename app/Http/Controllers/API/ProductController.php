<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all_product()
    {
        $products = Product::orderBy('description', 'ASC')->get();
        return response()->json([
            'products' => $products,
        ], 200);
    }
}
