<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE recurrences MODIFY COLUMN frequency ENUM('once', 'daily', 'weekly', 'monthly', 'yearly') NOT NULL");
    }

    public function down(): void
    {
        // Volta para o enum original (sem o 'once')
        DB::statement("ALTER TABLE recurrences MODIFY COLUMN frequency ENUM('daily', 'weekly', 'monthly', 'yearly') NOT NULL");
    }
};
