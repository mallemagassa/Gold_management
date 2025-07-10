<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocalGoldPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'weight_grams',
        'purity_estimated',
        'price_per_gram_local',
        'total_price',
        'purchase_date',
        'local_rate_id',
        'payment_status',
        'agent_id',
        'receipt_reference'
    ];

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
}

