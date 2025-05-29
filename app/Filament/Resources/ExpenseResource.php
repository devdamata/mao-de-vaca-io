<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Leandrocfe\FilamentPtbrFormFields\Money;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Despesas';
    protected static ?string $navigationLabel = 'Despesas';

    public static function getNavigationGroup(): ?string
    {
        return 'Despesas';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => Filament::auth()->user()->id)
                    ->required(),
                Forms\Components\Select::make('wallet_id')
                    ->label('Carteira')
                    ->relationship('wallet', 'name')
                    ->required(),
                Forms\Components\Select::make('expense_category_id')
                    ->label('Categoria')
                    ->placeholder('Selecione categoria')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->label('Descrição')
                    ->columnSpan('full')
                    ->required()
                    ->maxLength(255),
                Money::make('amount')
                    ->label('Valor')
                    ->default('00,00')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\Checkbox::make('is_recurring')
                    ->label('É recorrente?')
                    ->reactive()
                    ->default(fn (?Model $record ) => $record?->recurrence !== null),
                Forms\Components\Fieldset::make('Recorrência')
                    ->schema([
                        Forms\Components\Select::make('frequency')
                            ->label('Frequência')
                            ->options([
                                'daily' => 'Diariamente',
                                'weekly' => 'Semanalmente',
                                'monthly' => 'Mensalmente',
                                'yearly' => 'Anualmente',
                            ])
                            ->requiredIf('is_recurring', true),
                        Forms\Components\DatePicker::make('starts_at')
                            ->label('Data de Início')
                            ->requiredIf('is_recurring', true),
                        Forms\Components\DatePicker::make('ends_at')
                            ->label('Data de Fim'),
                    ])
                    ->columns(2)
                    ->visible(fn (Get $get): bool => $get('is_recurring')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('wallet.name')
                    ->label('Carteira')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Data')
                    ->date()
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_recurring')
                    ->label('Recorrencia')
                    ->boolean(),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
