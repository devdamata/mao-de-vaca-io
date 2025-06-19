<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIncome extends CreateRecord
{
    protected static string $resource = IncomeResource::class;

    protected static ?string $title = 'Adicionar Receita';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['is_recurring']) {
            // Salva a parte de recorrência em um campo separado para processar depois
            $this->recurrencyData = [
                'frequency' => $data['frequency'],
                'starts_at' => $data['starts_at'],
                'ends_at' => $data['ends_at'],
            ];

            // Remove os dados de recorrência do array principal
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
