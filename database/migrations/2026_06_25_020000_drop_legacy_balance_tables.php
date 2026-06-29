<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * As tabelas balances/balance_wallets foram substitu\u00eddas pelo ledger (transactions).
     * O saldo agora \u00e9 sempre derivado das transa\u00e7\u00f5es, n\u00e3o mais armazenado.
     */
    public function up(): void
    {
        Schema::dropIfExists('balances');
        Schema::dropIfExists('balance_wallets');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->decimal('total_received', 15, 2);
            $table->decimal('total_paid', 15, 2);
            $table->decimal('balance', 15, 2);
            $table->unsignedInteger('month');
            $table->unsignedInteger('year');
            $table->timestamps();

            $table->unique(['year', 'month']);
        });

        Schema::create('balance_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->decimal('balance', 10, 2)->default(0.00);
            $table->date('clossing_balance')->nullable();
            $table->timestamps();
        });
    }
};
