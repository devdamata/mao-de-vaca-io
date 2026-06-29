<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\ExpenseResource;
use Filament\Resources\Pages\ViewRecord;

class ViewExpense extends ViewRecord
{
    protected static string $resource = ExpenseResource::class;

    protected static ?string $title = 'Visualizar Despesa';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
