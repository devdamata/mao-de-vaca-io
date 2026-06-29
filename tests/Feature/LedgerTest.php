<?php

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\Parcel;
use App\Models\Recurrence;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;

function makeWallet(float $initialBalance = 0.0): Wallet
{
    $user = User::factory()->create();

    return Wallet::create([
        'user_id' => $user->id,
        'name' => 'Carteira Teste',
        'initial_balance' => $initialBalance,
    ]);
}

function makeRecurringExpense(Wallet $wallet, float $amount, string $startsAt, string $endsAt, string $frequency = 'monthly'): Expense
{
    $category = ExpenseCategory::create(['name' => 'Despesas']);

    $expense = Expense::create([
        'user_id' => $wallet->user_id,
        'wallet_id' => $wallet->id,
        'expense_category_id' => $category->id,
        'description' => 'Conta de luz',
        'amount' => $amount,
        'date' => $startsAt,
        'is_recurring' => true,
    ]);

    Recurrence::create([
        'frequency' => $frequency,
        'starts_at' => $startsAt,
        'ends_at' => $endsAt,
        'expense_id' => $expense->id,
    ]);

    return $expense;
}

function makeRecurringIncome(Wallet $wallet, float $amount, string $startsAt, string $endsAt, string $frequency = 'monthly'): Income
{
    $category = IncomeCategory::create(['name' => 'Salário']);

    $income = Income::create([
        'user_id' => $wallet->user_id,
        'wallet_id' => $wallet->id,
        'income_category_id' => $category->id,
        'description' => 'Salário',
        'amount' => $amount,
        'date' => $startsAt,
        'is_recurring' => true,
    ]);

    Recurrence::create([
        'frequency' => $frequency,
        'starts_at' => $startsAt,
        'ends_at' => $endsAt,
        'income_id' => $income->id,
    ]);

    return $income;
}

it('carteira nova tem saldo igual ao saldo inicial', function () {
    $wallet = makeWallet(-750.00);

    expect($wallet->transactions()->count())->toBe(0)
        ->and($wallet->currentBalance())->toBe(-750.00);
});

it('recorrência mensal gera uma parcela por mês', function () {
    $wallet = makeWallet(0);

    makeRecurringExpense($wallet, 100, '2026-01-10', '2026-03-10');

    expect(Parcel::count())->toBe(3);
});

it('pagar parcela de despesa cria transação e reduz o saldo', function () {
    $wallet = makeWallet(1000.00);
    makeRecurringExpense($wallet, 250.00, '2026-01-10', '2026-01-10');

    $parcel = Parcel::first();
    $parcel->update(['is_paid' => true]);

    expect(Transaction::count())->toBe(1)
        ->and(Transaction::first()->type)->toBe('expense')
        ->and($wallet->fresh()->currentBalance())->toBe(750.00);
});

it('pagar parcela de receita cria transação e aumenta o saldo', function () {
    $wallet = makeWallet(1000.00);
    makeRecurringIncome($wallet, 500.00, '2026-01-10', '2026-01-10');

    $parcel = Parcel::first();
    $parcel->update(['is_paid' => true]);

    expect(Transaction::count())->toBe(1)
        ->and(Transaction::first()->type)->toBe('income')
        ->and($wallet->fresh()->currentBalance())->toBe(1500.00);
});

it('despagar parcela remove a transação e reverte o saldo', function () {
    $wallet = makeWallet(1000.00);
    makeRecurringExpense($wallet, 250.00, '2026-01-10', '2026-01-10');

    $parcel = Parcel::first();
    $parcel->update(['is_paid' => true]);
    expect($wallet->fresh()->currentBalance())->toBe(750.00);

    $parcel->update(['is_paid' => false]);

    expect(Transaction::count())->toBe(0)
        ->and($wallet->fresh()->currentBalance())->toBe(1000.00);
});

it('excluir parcela paga remove a transação do ledger', function () {
    $wallet = makeWallet(1000.00);
    makeRecurringExpense($wallet, 250.00, '2026-01-10', '2026-01-10');

    $parcel = Parcel::first();
    $parcel->update(['is_paid' => true]);
    expect(Transaction::count())->toBe(1);

    $parcel->delete();

    expect(Transaction::count())->toBe(0)
        ->and($wallet->fresh()->currentBalance())->toBe(1000.00);
});

it('saldo combina receitas e despesas pagas', function () {
    $wallet = makeWallet(1000.00);
    makeRecurringIncome($wallet, 500.00, '2026-01-05', '2026-01-05');
    makeRecurringExpense($wallet, 200.00, '2026-01-15', '2026-01-15');

    Parcel::all()->each(fn (Parcel $parcel) => $parcel->update(['is_paid' => true]));

    expect($wallet->fresh()->currentBalance())->toBe(1300.00);
});

it('monthlyMovement retorna recebido, pago e líquido do mês', function () {
    $wallet = makeWallet(0);
    makeRecurringIncome($wallet, 500.00, '2026-01-05', '2026-01-05');
    makeRecurringExpense($wallet, 200.00, '2026-01-15', '2026-01-15');

    Parcel::all()->each(fn (Parcel $parcel) => $parcel->update(['is_paid' => true]));

    $movement = $wallet->fresh()->monthlyMovement(1, 2026);

    expect($movement['received'])->toBe(500.00)
        ->and($movement['paid'])->toBe(200.00)
        ->and($movement['net'])->toBe(300.00);
});

it('movimento de outro mês não afeta o mês consultado', function () {
    $wallet = makeWallet(0);
    makeRecurringIncome($wallet, 500.00, '2026-02-05', '2026-02-05');

    Parcel::first()->update(['is_paid' => true]);

    expect($wallet->fresh()->monthlyMovement(1, 2026)['received'])->toBe(0.0)
        ->and($wallet->fresh()->monthlyMovement(2, 2026)['received'])->toBe(500.00);
});
