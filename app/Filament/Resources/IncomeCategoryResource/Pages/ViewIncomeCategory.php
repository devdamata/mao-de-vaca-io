<?php

namespace App\Filament\Resources\IncomeCategoryResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\IncomeCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIncomeCategory extends ViewRecord
{
    protected static string $resource = IncomeCategoryResource::class;

    protected static ?string $title = 'Visualizar Categoria de Renda';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
