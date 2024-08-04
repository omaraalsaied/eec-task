<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Pharmacy;
use App\Services\ProductService;
use Illuminate\Console\Command;

class SearchCheapestPharmacies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:search-cheap {product_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $product_id = $this->argument('product_id');

        $product = Product::find($product_id);

        if (!$product) {
            $this->error('Invalid Product ID');
            return 1;
        }

        $cheapestPharmacies = Pharmacy::join('pharmacy_product', 'pharmacies.id', '=', 'pharmacy_product.pharmacy_id')
            ->where('pharmacy_product.product_id', $product_id)
            ->orderBy('pharmacy_product.price', 'asc')
            ->take(5)
            ->get(['pharmacies.id', 'pharmacies.name', 'pharmacy_product.price']);

        if ($cheapestPharmacies->isEmpty()) {
            $this->info("No pharmacies found with this product.");
            return 0;
        }

        $result = $cheapestPharmacies->map(function ($pharmacy) {
            return [
                'id' => $pharmacy->id,
                'name' => $pharmacy->name,
                'price' => $pharmacy->price,
            ];
        });

        $this->line(json_encode($result, JSON_PRETTY_PRINT));

        return 0;
    }
}
