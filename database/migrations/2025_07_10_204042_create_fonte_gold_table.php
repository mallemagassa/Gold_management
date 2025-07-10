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
            $table->decimal('weight_grams_min');
            $table->decimal('weight_grams_max');
            $table->decimal('densite');
            $table->decimal('purity_estimated', 5, 2)->nullable();
            $table->decimal('price_per_gram_local', 10, 2);
            $table->decimal('total_price', 12, 2);
            $table->date('fonte_date');
            $table->foreignId('local_rate_id')->nullable()->constrained('local_rates');            
            $table->foreignId('bareme_designation_carat_id')->constrained('bareme_designation_carats')->onDelete('cascade');
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
