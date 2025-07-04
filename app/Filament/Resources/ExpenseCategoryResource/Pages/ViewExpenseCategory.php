<?php

namespace App\Filament\Resources\ExpenseCategoryResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\ExpenseCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewExpenseCategory extends ViewRecord
{
    protected static string $resource = ExpenseCategoryResource::class;
    protected static ?string $title = 'Visualização Categoria de Despesa';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
