<?php

namespace App\Filament\Resources\RecurrenceResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\RecurrenceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecurrence extends EditRecord
{
    protected static string $resource = RecurrenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
