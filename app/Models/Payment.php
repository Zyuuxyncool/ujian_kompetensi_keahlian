<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'order_id',
        'reference',
        'provider',
        'amount',
        'currency',
        'qris_payload',
        'qris_url',
        'provider_transaction_id',
        'status',
        'expires_at',
        'paid_at',
        'raw_response'
    ];

    protected $casts = [
        'raw_response' => 'array',
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'status' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 1;
    }
}
