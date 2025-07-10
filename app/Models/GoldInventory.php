<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoldInventory extends Model
{

    protected $table = 'gold_inventorys';

    use HasFactory;

    protected $fillable = ['refining_batch_id', 'weight_available', 'location', 'status'];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(RefiningBatche::class, 'refining_batch_id');
    }

    public function shipmentItems(): HasMany
    {
        return $this->hasMany(ShipmentItem::class, 'inventory_id');
    }
}
