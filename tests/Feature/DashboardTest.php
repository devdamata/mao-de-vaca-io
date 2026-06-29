<?php

use App\Filament\Widgets\StatsOverview;
use App\Models\User;
use App\Models\Wallet;
use Filament\Facades\Filament;
use Livewire\Livewire;

it('carrega o dashboard autenticado renderizando os widgets', function () {
    $user = User::factory()->create();

    Wallet::create([
        'user_id' => $user->id,
        'name' => 'Itaú',
        'initial_balance' => 100.00,
    ]);

    $this->actingAs($user)
        ->get('/admin')
        ->assertSuccessful();
});

it('carrega o dashboard mesmo sem carteiras', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/admin')
        ->assertSuccessful();
});

it('renderiza os stats com uma carteira selecionada (id como string)', function () {
    $user = User::factory()->create();
    $wallet = Wallet::create([
        'user_id' => $user->id,
        'name' => 'Itaú',
        'initial_balance' => 100.00,
    ]);

    $this->actingAs($user);
    Filament::setCurrentPanel(Filament::getPanel('admin'));

    Livewire::test(StatsOverview::class, ['pageFilters' => ['wallet_id' => (string) $wallet->id]])
        ->assertOk();
});
