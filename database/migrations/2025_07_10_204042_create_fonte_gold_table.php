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
        Schema::create('fonte_gold', function (Blueprint $table) {
            $table->id();
            $table->decimal('weight_total_after_fonte');
            $table->decimal('weight_total_before_fonte');
            $table->decimal('court_fonte');
            $table->decimal('purity_estimated', 5, 2)->nullable();
            $table->decimal('total_price', 12, 2);
            $table->date('fonte_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fonte_gold');
    }
};
