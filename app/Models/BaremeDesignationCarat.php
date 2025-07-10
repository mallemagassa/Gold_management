<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BaremeDesignationCarat extends Model
{
    //
    protected $fillable = [
        'carat',
        'density_min',
        'density_max',
    ];

    public function achats(): HasMany{
        return $this->hasMany(LocalGoldPurchase::class);
    }
}
