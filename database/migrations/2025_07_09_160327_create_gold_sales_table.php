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
        Schema::create('gold_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('gold_shipments');
            $table->string('buyer_name', 100);
            $table->decimal('weight_sold', 10, 2);
            $table->decimal('price_per_gram', 10, 2);
            $table->decimal('total_price', 12, 2);
            $table->string('currency', 10);
            $table->date('sale_date');
            $table->enum('payment_status', ['pending', 'paid'])->default('pending');
            $table->string('invoice_number', 100)->unique();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_sales');
    }
};
