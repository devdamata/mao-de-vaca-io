<?php

namespace App\Filament\Resources\ExpenseCategoryResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\ExpenseCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExpenseCategories extends ListRecords
{
    protected static string $resource = ExpenseCategoryResource::class;
//    protected static ?string $title = 'Lista Categorias de Despesas';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
