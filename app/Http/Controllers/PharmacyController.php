<?php

namespace App\Http\Controllers;

use App\Models\Pharmacy;
use App\Models\Product;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pharmacies = Pharmacy::paginate(20);
        return view('pharmacies.index', compact('pharmacies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pharmacies.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required',
        ]);

        $pharmacy = Pharmacy::create($validatedData);
        return redirect()->route('pharmacies.show', $pharmacy)->with('success', 'Pharmacy created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pharmacy $pharmacy)
    {
        $pharmacy->load('products');
        return view('pharmacies.show', compact('pharmacy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pharmacy $pharmacy)
    {
        return view('pharmacies.form', compact('pharmacy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pharmacy $pharmacy)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required',
        ]);

        $pharmacy->update($validatedData);
        return redirect()->route('pharmacies.show', $pharmacy)->with('success', 'Pharmacy updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
        $pharmacy->delete();
        return redirect()->route('pharmacies.index')->with('success', 'Pharmacy deleted successfully.');

    }

    public function addProduct(Request $request, Pharmacy $pharmacy)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0'
        ]);

        $pharmacy->products()->attach($validatedData['product_id'], ['price' => $validatedData['price']]);
        return redirect()->route('pharmacies.show', $pharmacy)->with('success', 'Product added to pharmacy successfully.');
    }

    public function removeProduct(Request $request, Pharmacy $pharmacy)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $pharmacy->products()->detach($validatedData['product_id']);
        return redirect()->route('pharmacies.show', $pharmacy)->with('success', 'Product removed from pharmacy successfully.');
    }

    public function updateProductPrice (Request $request, Pharmacy $pharmacy, Product $product)
    {
        $validatedData = $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $pharmacy->products()->updateExistingPivot($product->id, ['price' => $validatedData['price']]);

        return redirect()->route('pharmacies.show', $pharmacy)->with('success', 'Product price updated successfully.');

    }
}
