<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use Filament\Actions\EditAction;
use App\Filament\Resources\IncomeResource;
use App\Models\Income;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ViewRecord;
use Leandrocfe\FilamentPtbrFormFields\Money;
use Filament\Forms;

class ViewIncome extends ViewRecord
{
    protected static string $resource = IncomeResource::class;

    protected static ?string $title = 'Visualizar Receita';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
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


