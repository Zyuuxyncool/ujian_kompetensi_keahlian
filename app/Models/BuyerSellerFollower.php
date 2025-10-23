<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerSellerFollower extends Model
{
    use HasFactory;

    protected $table = 'buyer_seller_followers';

    protected $fillable = [
        'buyer_id',
        'seller_id',
    ];

    public function buyer()
    {
        return $this->belongsTo(ProfilBuyer::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(ProfilSeller::class, 'seller_id');
    }
}
