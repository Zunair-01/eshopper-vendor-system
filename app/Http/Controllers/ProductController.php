<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $rules = [

        'price' => 'required|numeric',
        'category' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    $validator = Validator::make($request->all(), $rules);
    if($validator->fails()){
        return response()->json([
            'errors' => $validator->errors(),
            'status'=> false
        ]);
    }

    $product = new Product();
    $product->name = $request->input('name');
    $product->price = $request->input('price');
    $product->category = $request->input('category');
    $product->description = $request->input('description');
    $product->save();
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time().'.'.$image->extension();
        $image->move(public_path('images'), $imageName);
        $product->image = $imageName; // Save the image name, not the file object
        $product->save();
    }
    return response()->json([
        'message' => 'Product created successfully',
        'data' => $product,
        'status' => true
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $data = Product::all();
        return response()->json([
            'status'=>true,
            'data' => $data
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $id)
    {
        $product = Product::find($id);
        if($product){
            return response()->json([
                'status'=>true,
                'data' => $product
                ]);
        } else{
            return response()->json([
                'status'=>false,
                'message' =>"User Not found"
                ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        // Validate input data
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048' // Optional image validation
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => false
            ]);
        }

        // Find the product by ID
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
                'status' => false
            ]);
        }

        // Update product fields
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->category = $request->input('category');
        $product->description = $request->input('description');

        // Handle image upload if exists
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        // Save the updated product
        $product->save();

        return response()->json([
            'message' => 'Product updated successfully',
            'status' => true
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found.',
                'status' => false
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.',
            'status' => true
        ]);
    }
}
