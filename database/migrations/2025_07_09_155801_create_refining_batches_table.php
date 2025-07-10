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
        Schema::create('refining_batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_code')->unique();
            $table->decimal('total_weight_input', 10, 2)->nullable();
            $table->decimal('estimated_loss', 10, 2)->nullable();
            $table->decimal('refined_weight_output', 10, 2)->nullable();
            $table->decimal('refined_purity', 5, 2)->nullable();
            $table->date('refining_date')->nullable();
            $table->foreignId('responsible_id')->nullable()->constrained('users');
            $table->enum('status', ['pending', 'processed'])->default('pending');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refining_batches');
    }
};
