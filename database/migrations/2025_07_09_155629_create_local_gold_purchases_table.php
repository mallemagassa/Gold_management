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
        Schema::create('local_gold_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete();
            $table->decimal('weight_grams', 10, 2);
            $table->decimal('purity_estimated', 5, 2)->nullable();
            $table->decimal('price_per_gram_local', 10, 2);
            $table->decimal('total_price', 12, 2);
            $table->date('purchase_date');
            $table->foreignId('local_rate_id')->nullable()->constrained('local_rates');
            $table->enum('payment_status', ['pending', 'paid'])->default('pending');
            $table->foreignId('agent_id')->constrained('users');
            $table->string('receipt_reference')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local_gold_purchases');
    }
};
