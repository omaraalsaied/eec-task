<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function all()
    {
        return Product::paginate(20);
    }
    public function find($id)
    {
        return Product::find($id);
    }

    public function store(array $data)
    {
        return Product::create($data);
    }


    public function search(string $query, int $perPage)
    {
        return
         Product::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->paginate($perPage);
    }
}
