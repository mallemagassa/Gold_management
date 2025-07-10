<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoldShipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_code',
        'total_weight',
        'departure_date',
        'arrival_date',
        'status',
        'tracking_number',
        'carrier_name',
        'created_by'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ShipmentItem::class, 'shipment_id');
    }

    public function sale(): HasOne
    {
        return $this->hasOne(GoldSale::class);
    }
}
