<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Services\PharmacyService;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.form');
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
        return redirect()->route('products.show', $product)->with('success', 'Product Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('pharmacies');
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.form', compact('product'));

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
        return redirect()->route('products.show', $product)->with('success', 'Product Updated Successfully');
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
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }


    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = $this->productService->search($query, 10);

        return view('products.search', compact('products', 'query'));
    }
}
