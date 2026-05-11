<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('size');
            $table->integer('quantity');
            $table->timestamps();
            
            // Unique constraint: satu user hanya bisa 1 produk dengan size yang sama
            $table->unique(['user_id', 'product_id', 'size']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};