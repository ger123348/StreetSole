<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['paid', 'processed', 'shipped', 'delivered'])->default('paid');
            $table->decimal('subtotal', 12, 0);
            $table->decimal('shipping_cost', 10, 0)->default(25000);
            $table->decimal('discount', 10, 0)->default(50000);
            $table->decimal('total', 12, 0);
            $table->string('payment_method');
            $table->string('selected_bank')->nullable();
            $table->string('shipping_first_name');
            $table->string('shipping_last_name');
            $table->string('shipping_phone');
            $table->text('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_zip');
            $table->decimal('shipping_lat', 10, 8)->nullable();
            $table->decimal('shipping_lng', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};