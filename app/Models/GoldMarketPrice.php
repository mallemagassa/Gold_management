<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoldMarketPrice extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'price_per_gram_usd', 'source'];
}

