<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoldSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id',
        'buyer_name',
        'weight_sold',
        'price_per_gram',
        'total_price',
        'currency',
        'sale_date',
        'payment_status',
        'invoice_number',
        'created_by'
    ];

    public function shipment(): BelongsTo 
    {
        return $this->belongsTo(GoldShipment::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

