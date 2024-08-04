<?php

namespace App\Services;

use App\Repositories\PharmacyRepositoryInterface;


class PharmacyService
{

    public function __construct( protected PharmacyRepositoryInterface $pharmacyRepository)
    {
    }

    public function getPharmacyById($id)
    {
        return $this->pharmacyRepository->find($id);
    }

    public function getAllPharmacies()
    {
        return $this->pharmacyRepository->all();
    }

    public function createPharamcy(array $data)
    {
        return $this->pharmacyRepository->store($data);
    }

}
