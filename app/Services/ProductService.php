<?php

namespace App\Services;

use App\Repositories\ProductRepositoryInterface;


class ProductService
{
    public function __construct(protected ProductRepositoryInterface $productRepository)
    {
    }
    public function getAllProducts()
    {
        return $this->productRepository->all();
    }
    public function getProductById($id)
    {
        return $this->productRepository->find($id);
    }
    public function createProduct(array $data)
    {
        return $this->productRepository->store($data);
    }

    public function search($query, $perPage)
    {
        return $this->productRepository->search($query, $perPage);
    }
}
