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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->constrained('products')->onDelete('cascade');
            $table->foreignId('user_id')
                ->constrained('users')->onDelete('cascade');
            $table->string('gateway');
            $table->string('tnx_id')->nullable();
            $table->string('ref_id')->nullable();
            $table->double('amount')->nullable();
            $table->string('status')->comment('success, failed, pending');
            $table->string('status_code')->nullable();
            $table->text('notes')->nullable();
            $table->json('extra')->nullable();
            $table->json('response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
