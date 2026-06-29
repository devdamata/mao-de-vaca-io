<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Ledger de movimenta\u00e7\u00f5es: cada transa\u00e7\u00e3o \u00e9 um lan\u00e7amento e o saldo
     * \u00e9 sempre derivado da soma (saldo inicial da carteira + entradas - sa\u00eddas).
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parcel_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 10, 2);
            $table->string('description')->nullable();
            $table->date('occurred_at');
            $table->timestamps();

            $table->index(['wallet_id', 'occurred_at']);
        });

        $this->backfillFromPaidParcels();
    }

    /**
     * Gera transa\u00e7\u00f5es para parcelas que j\u00e1 estavam marcadas como pagas.
     */
    private function backfillFromPaidParcels(): void
    {
        if (! Schema::hasTable('parcels')) {
            return;
        }

        $paidParcels = DB::table('parcels')
            ->join('recurrences', 'recurrences.id', '=', 'parcels.recurrence_id')
            ->leftJoin('incomes', 'incomes.id', '=', 'recurrences.income_id')
            ->leftJoin('expenses', 'expenses.id', '=', 'recurrences.expense_id')
            ->where('parcels.is_paid', true)
            ->select(
                'parcels.id as parcel_id',
                'parcels.amount',
                'parcels.is_income',
                'parcels.due_date',
                DB::raw('COALESCE(incomes.wallet_id, expenses.wallet_id) as wallet_id'),
                DB::raw('COALESCE(incomes.description, expenses.description) as description'),
            )
            ->get();

        foreach ($paidParcels as $parcel) {
            if (! $parcel->wallet_id) {
                continue;
            }

            DB::table('transactions')->insert([
                'wallet_id' => $parcel->wallet_id,
                'parcel_id' => $parcel->parcel_id,
                'type' => $parcel->is_income ? 'income' : 'expense',
                'amount' => $parcel->amount,
                'description' => $parcel->description,
                'occurred_at' => $parcel->due_date,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
