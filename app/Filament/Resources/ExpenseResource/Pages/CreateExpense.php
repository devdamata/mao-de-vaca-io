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
            // Salva a parte de recorrência em um campo separado para processar depois
            $this->recurrencyData = [
                //'income_id' => $data['id'], // ID do Income
                'frequency' => $data['frequency'],
                'starts_at' => $data['starts_at'],
                'ends_at' => $data['ends_at'],
            ];

            // Remove os dados de recorrência do array principal
            unset($data['frequency'], $data['starts_at'], $data['ends_at']);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        if (!empty($this->recurrencyData)) {
            // Salva os dados de recorrência associados ao Income recém-criado
            $this->record->recurrence()->create($this->recurrencyData);
        }
    }
}
