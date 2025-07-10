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
        Schema::create('gold_shipments', function (Blueprint $table) {
            $table->id();
            $table->string('shipment_code')->unique();
            $table->decimal('total_weight', 10, 2)->nullable();
            $table->date('departure_date')->nullable();
            $table->date('arrival_date')->nullable();
            $table->enum('status', ['prepare', 'en_transit', 'livre'])->default('prepare');
            $table->string('tracking_number')->nullable();
            $table->string('carrier_name')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_shipments');
    }
};
