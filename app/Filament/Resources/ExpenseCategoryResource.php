<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\ExpenseCategoryResource\Pages\ListExpenseCategories;
use App\Filament\Resources\ExpenseCategoryResource\Pages;
use App\Filament\Resources\ExpenseCategoryResource\RelationManagers;
use App\Models\ExpenseCategory;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseCategoryResource extends Resource
{
    protected static ?string $model = ExpenseCategory::class;

    protected static ?string $label = 'Categorias de Despesas';
    protected static ?string $navigationLabel = 'Categorias de Despesa';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Despesas';
    }

    public static function getEloquentQuery(): Builder
    {
        $userId = Filament::auth()->id();

        // Categorias globais (user_id nulo) + categorias do próprio usuário
        return parent::getEloquentQuery()
            ->where(fn (Builder $query) => $query
                ->whereNull('user_id')
                ->orWhere('user_id', $userId));
    }

    public static function canEdit(Model $record): bool
    {
        return $record->user_id === Filament::auth()->id();
    }

    public static function canDelete(Model $record): bool
    {
        return $record->user_id === Filament::auth()->id();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(fn () => Filament::auth()->id()),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nome da categoria')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('name')->label('Categoria'),
                TextColumn::make('created_at')->label('Criado em')->dateTime('d/m/Y H:i:s'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
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
            'index' => ListExpenseCategories::route('/'),
//            'create' => Pages\CreateExpenseCategory::route('/create'),
//            'view' => Pages\ViewExpenseCategory::route('/{record}'),
//            'edit' => Pages\EditExpenseCategory::route('/{record}/edit'),
        ];
    }
}
