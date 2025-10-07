<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUSES = [
        0 => 'pending',
        1 => 'paid',
        2 => 'shipped',
        3 => 'completed',
        4 => 'cancelled'
    ];

    protected $fillable = [
        'user_id',
        'total_price',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusCaptionAttribute()
    {
        return self::STATUSES[$this->attributes['status']] ?? 'Unknown';
    }
}
