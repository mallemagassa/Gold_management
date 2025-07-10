<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FonteGold extends Model
{
    protected $fillable = [
        'weight_grams_min',
        'weight_grams_max',
        'densite',
        'purity_estimated',
        'price_per_gram_local',
        'total_price',
        'fonte_date',
        'local_rate_id',
        'bareme_designation_carat_id',
    ];

    public static function relationsToLoad(): array
    {
        return ['localRate', 'baremeDesignationCarat'];
    }

    public function localRate(): BelongsTo
    {
        return $this->belongsTo(LocalRate::class);
    }

    public function baremeDesignationCarat(): BelongsTo
    {
        return $this->belongsTo(BaremeDesignationCarat::class);
    }

    // Calcul de la densité
    public function calculateDensity(): float
    {
        if ($this->weight_grams_max && $this->weight_grams_min) {
            $difference = $this->weight_grams_max - $this->weight_grams_min;
            return $difference > 0 ? $this->weight_grams_max / $difference : 0;
        }
        return 0;
    }

    // Calcul de la pureté
    public function calculatePurity(): float
    {
        if ($this->baremeDesignationCarat) {
            return ($this->baremeDesignationCarat->carat * 100) / 24;
        }
        return 0;
    }
}