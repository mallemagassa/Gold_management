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
        Schema::create('gold_inventorys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('refining_batch_id')->constrained('refining_batches');
            $table->decimal('weight_available', 10, 2);
            $table->string('location', 100)->nullable();
            $table->enum('status', ['en_stock', 'reserve', 'en_transit', 'vendu'])->default('en_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_inventories');
    }
};
