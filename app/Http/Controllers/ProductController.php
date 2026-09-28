<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Product::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'sku' => 'required|string|unique:products,sku',
            'price' => 'nullable|string',
            'available' => 'nullable|integer|min:0',
            'status' => 'nullable|in:active,inactive',
            'description' => 'nullable|string',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'data' => $product,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'data' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'type' => 'nullable|string|max:255',
            'sku' => 'sometimes|required|string|unique:products,sku,' . $product->id,
            'price' => 'nullable|string',
            'available' => 'nullable|integer|min:0',
            'status' => 'nullable|in:active,inactive',
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return response()->json([
            'data' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200);
    }
}

