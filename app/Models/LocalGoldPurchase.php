<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocalGoldPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'purchase_date',
        'payment_status',
        'agent_id',
        'receipt_reference'
    ];

    // Dans LocalGoldPurchase.php
    public function items(): HasMany
    {
        return $this->hasMany(LocalGoldPurchaseItem::class);
    }

    public function updateInventory()
    {
        foreach ($this->items as $item) {
            $inventoryItem = GoldInventoryItem::firstOrCreate(
                ['court' => $item->baremeDesignationCarat->carat],
                ['weight_available' => 0, 'gold_inventory_id' => 1] // 1 ou votre ID d'inventaire par défaut
            );
            
            $inventoryItem->increment('weight_available', $item->weight_grams_max);
            $inventoryItem->save();
        }
    }

    public static function relationsToLoad(): array
    {
        return ['supplier', 'localRate', 'agent'];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function localRate(): BelongsTo
    {
        return $this->belongsTo(LocalRate::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function baremeDesignationCarat(): BelongsTo{
        return $this->belongsTo(BaremeDesignationCarat::class);
    }
}

