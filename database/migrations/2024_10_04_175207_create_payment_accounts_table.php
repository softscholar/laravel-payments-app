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
        Schema::create('payment_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')->onDelete('cascade');
            $table->string('account_name')->nullable();
            $table->string('account_no');
            $table->string('gateway');
            $table->string('customer_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('status')->default('pending');
            $table->text('payment_ref_id')->nullable();
            $table->longText('token')->nullable();
            $table->longText('token_type')->nullable();
            $table->string('token_expire_at')->nullable();
            $table->json('extra')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_accounts');
    }
};
