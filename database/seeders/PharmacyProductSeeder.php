<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Pharmacy;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PharmacyProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $pharmacies = Pharmacy::all();

        foreach ($pharmacies as $pharmacy) {
            $randomProducts = $products->random(rand(1, 10));
            $pharmacy->products()->attach($randomProducts);
        }
    }
}
