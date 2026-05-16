<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Make optional shipping fields nullable.
     */
    public function up(): void
    {
        // Make optional fields nullable
        DB::statement("ALTER TABLE orders MODIFY shipping_last_name VARCHAR(255) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE orders MODIFY shipping_zip VARCHAR(255) NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY shipping_last_name VARCHAR(255) NOT NULL");
        DB::statement("ALTER TABLE orders MODIFY shipping_zip VARCHAR(255) NOT NULL");
    }
};
