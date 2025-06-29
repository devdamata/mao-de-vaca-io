<?php

namespace App\Filament\Resources\RecurrenceResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\RecurrenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRecurrence extends ViewRecord
{
    protected static string $resource = RecurrenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
