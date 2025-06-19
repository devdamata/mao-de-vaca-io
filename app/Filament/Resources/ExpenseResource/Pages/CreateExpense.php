<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Filament\Resources\ExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['is_recurring']) {

            $this->recurrencyData = [
                'frequency' => $data['frequency'],
                'starts_at' => $data['starts_at'],
                'ends_at' => $data['ends_at'],
            ];

            unset($data['frequency'], $data['starts_at'], $data['ends_at']);

        } else {
            $this->recurrencyData = [
                'frequency' => 'once',
                'starts_at' => $data['date'],
                'ends_at' => $data['date'],
            ];
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->recurrence()->create($this->recurrencyData);
    }
}
