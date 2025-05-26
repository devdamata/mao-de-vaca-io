<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use App\Models\Income;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncome extends EditRecord
{
    protected static string $resource = IncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {

        if ($data['is_recurring'])
        {
            $recurrence = Income::with('recurrence')
                ->where('id', $data['id'])
                ->first()
                ->recurrence
                ->toArray();
            $data['frequency'] = $recurrence['frequency'];
            $data['starts_at'] = $recurrence['starts_at'];
            $data['ends_at'] = $recurrence['ends_at'];
        }

        return $data;
    }
}
