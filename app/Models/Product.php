<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'img', 'price', 'quantity'];

    public function pharmacies()
    {
        return $this->belongsToMany(Pharmacy::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->img ? Storage::url($this->img) : null;
    }


}
