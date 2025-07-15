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

    protected $fillable = [
        'court', 
    ];
}
