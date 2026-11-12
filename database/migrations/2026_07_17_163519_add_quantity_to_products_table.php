<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if column exists using raw SQL
        $columns = DB::select("SHOW COLUMNS FROM products LIKE 'quantity'");
        
        if (empty($columns)) {
            DB::statement("ALTER TABLE products ADD COLUMN quantity INT DEFAULT 0 AFTER price");
        }
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE products DROP COLUMN quantity");
    }
};