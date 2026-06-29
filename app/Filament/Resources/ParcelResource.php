<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParcelResource\Pages;
use App\Filament\Resources\ParcelResource\Pages\ListParcels;
use App\Models\Parcel;
use App\Models\Wallet;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Leandrocfe\FilamentPtbrFormFields\Money;

class ParcelResource extends Resource
{
    protected static ?string $model = Parcel::class;

    protected static ?string $label = 'Pacelas';

    protected static ?string $navigationLabel = 'Parcelas';

    protected static string|\UnitEnum|null $navigationGroup = 'Recorrências e Parcelamentos';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Recorrências e Parcelamentos';
    }

    public static function getEloquentQuery(): Builder
    {
        $userId = Filament::auth()->id();

        return parent::getEloquentQuery()
            ->whereHas('recurrence', function (Builder $query) use ($userId) {
                $query->whereHas('income', fn (Builder $q) => $q->where('user_id', $userId))
                    ->orWhereHas('expenses', fn (Builder $q) => $q->where('user_id', $userId));
            });
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('recurrence_id')
                    ->label('Nome da Receita/Despesa')
                    ->required()
                    ->disabled()
                    ->formatStateUsing(function ($state, $component) {
                        $record = $component->getRecord();

                        return $record?->recurrence?->income?->description
                            ?? $record?->recurrence?->expenses?->description
                            ?? '-';
                    }),
                DatePicker::make('due_date')
                    ->label('Data de Vencimento')
                    ->disabled()
                    ->required(),
                Money::make('amount')
                    ->label('Valor')
                    ->default('00,00')
                    ->disabled()
                    ->required(),
                Toggle::make('is_income')
                    ->label('É Receita?')
                    ->disabled()
                    ->required(),
                Toggle::make('is_paid')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('recurrence')
                    ->label('Nome da Receita/Despesa')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return $state->income?->description ?? $state->expenses?->description ?? '-';
                    }),
                TextColumn::make('due_date')
                    ->label('Data de Vencimento')
                    ->date()
                    ->dateTime('d/m/Y')
                    ->sortable(),
                TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL', true)
                    ->sortable(),
                IconColumn::make('is_income')
                    ->label('É Receita?')
                    ->boolean(),
                TextColumn::make('situacao')
                    ->label('Situação')
                    ->badge()
                    ->state(fn (Parcel $record): string => match (true) {
                        $record->is_paid => 'Paga',
                        $record->due_date->lt(today()) => 'Vencida',
                        default => 'A vencer',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Paga' => 'success',
                        'Vencida' => 'danger',
                        default => 'warning',
                    }),
                ToggleColumn::make('is_paid')
                    ->label('Pago')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->inline(false),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('due_date', 'asc')
            ->filters([
                TernaryFilter::make('is_paid')
                    ->label('Pagamento')
                    ->placeholder('Todas')
                    ->trueLabel('Pagas')
                    ->falseLabel('Em aberto'),
                TernaryFilter::make('is_income')
                    ->label('Tipo')
                    ->placeholder('Todos')
                    ->trueLabel('Receitas')
                    ->falseLabel('Despesas'),
                SelectFilter::make('wallet')
                    ->label('Carteira')
                    ->options(fn (): array => Wallet::query()
                        ->where('user_id', Filament::auth()->id())
                        ->pluck('name', 'id')
                        ->all())
                    ->query(function (Builder $query, array $data): Builder {
                        if (blank($data['value'] ?? null)) {
                            return $query;
                        }

                        $walletId = $data['value'];

                        return $query->whereHas('recurrence', function (Builder $q) use ($walletId) {
                            $q->whereHas('income', fn (Builder $i) => $i->where('wallet_id', $walletId))
                                ->orWhereHas('expenses', fn (Builder $e) => $e->where('wallet_id', $walletId));
                        });
                    }),
                Filter::make('vencidas')
                    ->label('Somente vencidas')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query
                        ->where('is_paid', false)
                        ->whereDate('due_date', '<', today())),
                Filter::make('proximos_30_dias')
                    ->label('Vencem em 30 dias')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query
                        ->where('is_paid', false)
                        ->whereBetween('due_date', [today(), today()->addDays(30)])),
                Filter::make('mes_atual')
                    ->label('Deste mês')
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query
                        ->whereMonth('due_date', now()->month)
                        ->whereYear('due_date', now()->year)),
            ])
            ->recordActions([
                Action::make('togglePaid')
                    ->label(fn (Parcel $record): string => $record->is_paid ? 'Estornar' : 'Pagar')
                    ->icon(fn (Parcel $record): string => $record->is_paid ? 'heroicon-o-arrow-uturn-left' : 'heroicon-o-check-circle')
                    ->color(fn (Parcel $record): string => $record->is_paid ? 'gray' : 'success')
                    ->action(fn (Parcel $record) => $record->update(['is_paid' => ! $record->is_paid])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('marcarPago')
                        ->label('Marcar como pago')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->action(fn (Collection $records) => $records->each->update(['is_paid' => true])),
                    BulkAction::make('marcarNaoPago')
                        ->label('Marcar como não pago')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->action(fn (Collection $records) => $records->each->update(['is_paid' => false])),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListParcels::route('/'),
            //            'create' => Pages\CreateParcel::route('/create'),
            //            'edit' => Pages\EditParcel::route('/{record}/edit'),
        ];
    }
}
