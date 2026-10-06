<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class CustomerProductController extends Controller
{
    public function show(Product $product)
    {
        $data = Product::all();
        return response()->json([
            'status'=>true,
            'data' => $data
            ]);
    }
    public function showCategories()
{
    // Fetch distinct categories and count products in each category
    $categories = Product::select('category')
        ->selectRaw('COUNT(*) as count')
        ->groupBy('category')
        ->get();

    // Count the total number of products
    $totalProducts = Product::count();

    return response()->json([
        'status' => true,
        'categories' => $categories,
        'totalProducts' => $totalProducts // Total count for "All" category
    ]);
}

public function showProductsByCategory($category = null)
{
    if ($category === 'all') {
        $products = Product::all(); // Fetch all products if category is 'all'
    } else {
        $products = Product::where('category', $category)->get(); // Fetch products by category
    }

    return response()->json([
        'status' => true,
        'products' => $products
    ]);
}



}
