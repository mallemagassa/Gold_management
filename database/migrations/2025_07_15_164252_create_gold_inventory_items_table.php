<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gold_inventory_items', function (Blueprint $table) {
            $table->id();
            $table->decimal('court', 10, 2);
            $table->decimal('weight_available', 10, 2);
            $table->foreignId('gold_inventory_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_inventory_items');
    }
};
