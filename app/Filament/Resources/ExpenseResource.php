<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\ExpenseResource\Pages\ListExpenses;
use App\Filament\Resources\ExpenseResource\Pages\CreateExpense;
use App\Filament\Resources\ExpenseResource\Pages\EditExpense;
use App\Filament\Resources\ExpenseResource\Pages;
use App\Filament\Resources\ExpenseResource\RelationManagers;
use App\Models\Expense;
use Filament\Facades\Filament;
use Filament\Forms;
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

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Despesas';
    protected static ?string $navigationLabel = 'Despesas';

    public static function getNavigationGroup(): ?string
    {
        return 'Despesas';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(fn () => Filament::auth()->user()->id)
                    ->required(),
                Select::make('wallet_id')
                    ->label('Carteira')
                    ->relationship('wallet', 'name')
                    ->required(),
                Select::make('expense_category_id')
                    ->label('Categoria')
                    ->placeholder('Selecione categoria')
                    ->relationship('category', 'name')
                    ->required(),
                TextInput::make('description')
                    ->label('Descrição')
                    ->columnSpan('full')
                    ->required()
                    ->maxLength(255),
                Money::make('amount')
                    ->label('Valor')
                    ->default('00,00')
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                Checkbox::make('is_recurring')
                    ->label('É recorrente?')
                    ->reactive()
                    ->default(fn (?Model $record ) => $record?->recurrence !== null),
                Fieldset::make('Recorrência')
                    ->schema([
                        Select::make('frequency')
                            ->label('Frequência')
                            ->options([
                                'daily' => 'Diariamente',
                                'weekly' => 'Semanalmente',
                                'monthly' => 'Mensalmente',
                                'yearly' => 'Anualmente',
                            ])
                            ->requiredIf('is_recurring', true),
                        DatePicker::make('starts_at')
                            ->label('Data de Início')
                            ->requiredIf('is_recurring', true),
                        DatePicker::make('ends_at')
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
                TextColumn::make('wallet.name')
                    ->label('Carteira')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Data')
                    ->date()
                    ->dateTime('d/m/Y')
                    ->sortable(),
                IconColumn::make('is_recurring')
                    ->label('Recorrencia')
                    ->boolean(),
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
            'index' => ListExpenses::route('/'),
            'create' => CreateExpense::route('/create'),
            'edit' => EditExpense::route('/{record}/edit'),
        ];
    }
}
