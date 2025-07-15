<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FonteGold extends Model
{
    protected $fillable = [
        'weight_total_after_fonte',
        'weight_total_before_fonte',
        'court_fonte',
        'purity_estimated',
        'total_price',
        'fonte_date',
        // 'densite',
        // 'weight_grams_min',
        // 'local_rate_id',
        // 'bareme_designation_carat_id',
    ];
}