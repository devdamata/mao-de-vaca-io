<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\ParcelResource\Pages\ListParcels;
use App\Filament\Resources\ParcelResource\Pages;
use App\Filament\Resources\ParcelResource\RelationManagers;
use App\Models\Parcel;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Leandrocfe\FilamentPtbrFormFields\Money;

class ParcelResource extends Resource
{
    protected static ?string $model = Parcel::class;

    protected static ?string $label = 'Pacelas';
    protected static ?string $navigationLabel = 'Parcelas';
    protected static string | \UnitEnum | null $navigationGroup = 'Recorrências e Parcelamentos';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Recorrências e Parcelamentos';
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
                            ?? $record?->recurrence?->expense?->description
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
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
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
