<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'contact_info',
        'identification_number',
    ];

    public function purchases(): HasMany
    {
        return $this->hasMany(LocalGoldPurchase::class);
    }
}
