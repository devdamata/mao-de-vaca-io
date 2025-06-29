<?php

namespace App\Filament\Resources\ParcelResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\ParcelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditParcel extends EditRecord
{
    protected static string $resource = ParcelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
