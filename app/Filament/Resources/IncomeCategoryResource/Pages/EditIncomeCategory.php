<?php

namespace App\Filament\Resources\IncomeCategoryResource\Pages;

use App\Filament\Resources\IncomeCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncomeCategory extends EditRecord
{
    protected static string $resource = IncomeCategoryResource::class;
    protected static ?string $title = 'Editar Categoria de Renda';

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
