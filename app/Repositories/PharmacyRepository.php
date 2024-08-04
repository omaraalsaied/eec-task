<?php

namespace App\Repositories;

use App\Models\Pharmacy;

class PharmacyRepository implements PharmacyRepositoryInterface
{
    public function all()
    {
        return Pharmacy::paginate(20);
    }
    public function find($id)
    {
        return Pharmacy::find($id);
    }

    public function store(array $data)
    {
        return Pharmacy::create($data);
    }

}
