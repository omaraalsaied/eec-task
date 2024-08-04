<?php
namespace App\Repositories;
interface PharmacyRepositoryInterface
{
    public function all();
    public function store(array $data);
    public function find($id);

}
