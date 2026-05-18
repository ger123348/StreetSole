<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     * Change payment_method from ENUM to VARCHAR so it accepts 'midtrans' and any value.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE orders MODIFY payment_method VARCHAR(100) NOT NULL DEFAULT 'midtrans'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY payment_method ENUM('transfer','dana','qris','cod','midtrans') NOT NULL");
    }
};
