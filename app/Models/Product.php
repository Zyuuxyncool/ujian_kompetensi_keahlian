<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable; 

class Product extends Model
{
    use HasFactory, Searchable; 

    protected $table = 'products';
    protected $fillable = [
        'profil_id',
        'uuid',
        'name',
        'description',
        'price',
        'stock',
        'sub_category_id',
        'brand_id'
    ];

    public function toSearchableArray(): array
    {
        // Data yang diindeks untuk Elasticsearch
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
        ];
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function profilSeller()
    {
        return $this->belongsTo(ProfilSeller::class, 'profil_id', 'id');
    }

    // public function first_image()
    // {
    //     return $this->hasOne(ProductImage::class)->oldest();
    // }
}
