<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'uuid',
        'name',
        'photo',
    ];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
