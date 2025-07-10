<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShipmentItem extends Model
{
    use HasFactory;

    protected $fillable = ['shipment_id', 'inventory_id', 'weight'];

    public function shipment(): BelongsTo
    {
        return $this->belongsTo(GoldShipment::class);
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(GoldInventory::class, 'inventory_id');
    }
}
