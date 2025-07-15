<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocalGoldPurchaseItem extends Model
{
    protected $fillable = [
        'weight_grams_min',
        'weight_grams_max',
        'densite',
        'purity_estimated',
        'price_per_gram_local',
        'total_price',
        'local_rate_id',
        'bareme_designation_carat_id',
        'local_gold_purchase_id',
    ];

    public function baremeDesignationCarat(): BelongsTo{
        return $this->belongsTo(BaremeDesignationCarat::class);
    }

    public function localRate(): BelongsTo
    {
        return $this->belongsTo(LocalRate::class);
    }

    public function localGoldPurchase(): BelongsTo
    {
        return $this->belongsTo(LocalGoldPurchase::class);
    }


}
