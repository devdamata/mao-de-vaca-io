<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParcelResource\Pages;
use App\Filament\Resources\ParcelResource\RelationManagers;
use App\Models\Parcel;
use Filament\Forms;
use Filament\Forms\Form;
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
    protected static ?string $navigationGroup = 'Recorrências e Parcelamentos';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Recorrências e Parcelamentos';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('recurrence_id')
                    ->label('Nome da Receita/Despesa')
                    ->required()
                    ->disabled()
                    ->formatStateUsing(function ($state, $component) {
                        $record = $component->getRecord();

                        return $record?->recurrence?->income?->description
                            ?? $record?->recurrence?->expense?->description
                            ?? '-';
                    }),
                Forms\Components\DatePicker::make('due_date')
                    ->label('Data de Vencimento')
                    ->disabled()
                    ->required(),
                Money::make('amount')
                    ->label('Valor')
                    ->default('00,00')
                    ->disabled()
                    ->required(),
                Forms\Components\Toggle::make('is_income')
                    ->label('É Receita?')
                    ->disabled()
                    ->required(),
                Forms\Components\Toggle::make('is_paid')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('recurrence')
                    ->label('Nome da Receita/Despesa')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return $state->income?->description ?? $state->expenses?->description ?? '-';
                    }),
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Data de Vencimento')
                    ->date()
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL', true)
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_income')
                    ->label('É Receita?')
                    ->boolean(),
                ToggleColumn::make('is_paid')
                    ->label('Pago')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->onColor('success')
                    ->offColor('danger')
                    ->inline(false),
        Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListParcels::route('/'),
//            'create' => Pages\CreateParcel::route('/create'),
//            'edit' => Pages\EditParcel::route('/{record}/edit'),
        ];
    }
}
