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
        Schema::create('bareme_designation_carats', function (Blueprint $table) {
            $table->id();
            $table->decimal('carat', 5, 2);
            $table->decimal('density_min', 5, 2);
            $table->decimal('density_max', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bareme_designation_carats');
    }
};
