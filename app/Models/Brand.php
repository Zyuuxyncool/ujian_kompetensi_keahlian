<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = [
        'uuid',
        'name',
        'photo',
        'category_id'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
