<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First we have to change the enum status or we can just replace string with varchar
        Schema::table('orders', function (Blueprint $table) {
            $table->string('snap_token', 36)->nullable();
            $table->string('payment_status', 50)->default('pending');
        });
        
        // Since sqlite or certain mysql versions have quirks with altering enums, 
        // a simple way is just using payment_status to track Midtrans separate from shipping 'status'.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'payment_status']);
        });
    }
};
