<?php

namespace App\Filament\Resources\IncomeCategoryResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\IncomeCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncomeCategories extends ListRecords
{
    protected static string $resource = IncomeCategoryResource::class;
    protected static ?string $title = 'Categorias de Renda';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
