<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoldInventoryItem extends Model
{
    //
    protected $fillable = [
        'court', 
        'weight_available', 
        'gold_inventory_id', 
    ];

    public function gold_inventory(){
        return $this->belongsTo(GoldInventory::class);
    }
}
