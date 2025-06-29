<?php

namespace App\Filament\Resources\RecurrenceResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\RecurrenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecurrences extends ListRecords
{
    protected static string $resource = RecurrenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
