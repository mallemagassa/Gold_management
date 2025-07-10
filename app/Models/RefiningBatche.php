<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RefiningBatche extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_code',
        'total_weight_input',
        'estimated_loss',
        'refined_weight_output',
        'refined_purity',
        'refining_date',
        'responsible_id',
        'status'
    ];

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    public function inventory(): HasMany
    {
        return $this->hasMany(GoldInventory::class);
    }
}

