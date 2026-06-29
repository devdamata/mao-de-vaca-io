<?php

namespace App\Filament\Widgets;

use App\Models\Parcel;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingBills extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $userId = Filament::auth()->id();
        $walletId = $this->pageFilters['wallet_id'] ?? null;

        return $table
            ->heading('Contas a vencer e vencidas')
            ->description('Parcelas em aberto até os próximos 30 dias')
            ->query(
                Parcel::query()
                    ->where('is_paid', false)
                    ->whereDate('due_date', '<=', today()->addDays(30))
                    ->whereHas('recurrence', function (Builder $query) use ($userId, $walletId) {
                        $query->whereHas('income', function (Builder $income) use ($userId, $walletId) {
                            $income->where('user_id', $userId)
                                ->when($walletId, fn (Builder $q) => $q->where('wallet_id', $walletId));
                        })->orWhereHas('expenses', function (Builder $expense) use ($userId, $walletId) {
                            $expense->where('user_id', $userId)
                                ->when($walletId, fn (Builder $q) => $q->where('wallet_id', $walletId));
                        });
                    })
            )
            ->defaultSort('due_date', 'asc')
            ->columns([
                TextColumn::make('recurrence')
                    ->label('Descrição')
                    ->formatStateUsing(fn ($state): string => $state?->income?->description
                        ?? $state?->expenses?->description
                        ?? '-'),
                TextColumn::make('due_date')
                    ->label('Vencimento')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL'),
                TextColumn::make('situacao')
                    ->label('Situação')
                    ->badge()
                    ->state(fn (Parcel $record): string => $record->due_date->lt(today()) ? 'Vencida' : 'A vencer')
                    ->color(fn (string $state): string => $state === 'Vencida' ? 'danger' : 'warning'),
            ])
            ->recordActions([
                Action::make('pagar')
                    ->label('Pagar')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn (Parcel $record) => $record->update(['is_paid' => true])),
            ])
            ->paginated([5, 10, 25]);
    }
}
