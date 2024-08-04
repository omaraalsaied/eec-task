<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();
        return response()->json([
            'status' => 'success',
            'data' => $products
        ], 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'min:3|max:1000',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('products', 'public');
            $validatedData['img'] = $imgPath;
        }

        $product = $this->productService->createProduct($validatedData);
        return response()->json([
            'status' => 'Product Created !',
            'data' => $product
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        if ($product) {
            $product->load('pharmacies');
            return response()->json([
                'status' => 'success',
                'data' => $product
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'data' => 'not found'
            ], 404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'min:3|max:1000',
            'img' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);
        if ($request->hasFile('img')) {
            if ($product->img) {
                Storage::disk('public')->delete($product->img);
            }

            $imgPath = $request->file('img')->store('products', 'public');
            $validatedData['img'] = $imgPath;
        }
        $product->update($validatedData);

        return response()->json([
            'status' => 'Product Updated Successfully',
            'data' => $product
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->img) {
            Storage::disk('public')->delete($product->img);
        }

        $product->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully'
        ], 204);
    }

    public function search (Request $request)
    {
        $query = $request->input('query');

        $products = $this->productService->search($query, 10);

        if(!$products || count($products) == 0)
        {
            return response()->json([
                'status' => 'success',
                'message' => 'No products found.'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => $products
        ], 200);
    }
}
