<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\IncomeCategoryResource\Pages\ListIncomeCategories;
use App\Filament\Resources\IncomeCategoryResource\Pages\CreateIncomeCategory;
use App\Filament\Resources\IncomeCategoryResource\Pages\ViewIncomeCategory;
use App\Filament\Resources\IncomeCategoryResource\Pages\EditIncomeCategory;
use App\Filament\Resources\IncomeCategoryResource\Pages;
use App\Models\IncomeCategory;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class IncomeCategoryResource extends Resource
{
    protected static ?string $model = IncomeCategory::class;
    protected static ?string $navigationLabel = 'Categorias de Receitas';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-tag';
    public static function getNavigationGroup(): ?string
    {
        return 'Receitas';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            'index' => ListIncomeCategories::route('/'),
            'create' => CreateIncomeCategory::route('/create'),
            'view' => ViewIncomeCategory::route('/{record}'),
            'edit' => EditIncomeCategory::route('/{record}/edit'),
        ];
    }

    public static function getNavigation(): array
    {
        return [
            'label' => 'Categorias de Receitas',
            'group' => 'Receitas',
            'sort' => 2, // Este menu aparecerá primeiro
            'icon' => 'heroicon-o-tag',
        ];
    }

}
