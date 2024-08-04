<?php
namespace App\Repositories;

interface ProductRepositoryInterface
{
    public function all();
    public function store(array $data);
    public function find($id);
    public function search(string $query, int $perPage);


}
