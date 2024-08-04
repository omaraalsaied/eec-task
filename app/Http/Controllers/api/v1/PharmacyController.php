<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Product;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Services\PharmacyService;
use App\Http\Controllers\Controller;

class PharmacyController extends Controller
{
    public function __construct(protected PharmacyService $pharmacyService)
    {
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pharmacies = $this->pharmacyService->getAllPharmacies();
        return response()->json([
            'status' => 'success',
            'data' => $pharmacies
        ], 200);
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

        $pharmacy = $this->pharmacyService->createPharamcy($validatedData);
        return response()->json([
            'status' => 'Pharmacy Created !',
            'data' => $pharmacy
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pharmacy $pharmacy)
    {
        $pharmacy->load('products');
        return response()->json([
            'status' => 'success',
            'data' => $pharmacy
        ], 200);
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
        return response()->json([
            'status' => 'Pharmacy Updated !',
            'data' => $pharmacy
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
        $pharmacy->delete();
        return response()->json([
            'status' => 'Pharmacy Deleted !'
        ], 204);
    }

    public function addProduct(Request $request, Pharmacy $pharmacy)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0'
        ]);

        $pharmacy->products()->attach($validatedData['product_id'], ['price' => $validatedData['price']]);
        return response()->json([
            'status' => 'Product Added to Pharmacy Successfully !',
            'data' => $pharmacy
        ], 200);
    }

    public function removeProduct(Request $request, Pharmacy $pharmacy)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        if ($pharmacy->products()->where('product_id', $request->product_id)->exists()) {
            return redirect()->back()->with('error', 'This product is already associated with the pharmacy.');
        }


        $pharmacy->products()->detach($validatedData['product_id']);
        return response()->json([
            'status' => 'Product removed from Pharmacy !',
            'data' => $pharmacy
        ], 200);
    }

    public function updateProductPrice(Request $request, Pharmacy $pharmacy, Product $product)
    {
        $validatedData = $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $pharmacy->products()->updateExistingPivot($product->id, ['price' => $validatedData['price']]);
        return response()->json([
            'status' => 'Product\'s Price Updated for Pharmacy ' . $pharmacy->name,
            'data' => $pharmacy
        ], 200);
    }

    public function getAvailableProducts(Pharmacy $pharmacy)
    {
        $existing_products = $pharmacy->products->pluck('id')->toArray();
        $availableProducts = Product::whereNotIn('id', $existing_products)->get();

        return response()->json([
            'status' => 'success' ,
            'data' => $availableProducts
        ], 200);
    }

}
