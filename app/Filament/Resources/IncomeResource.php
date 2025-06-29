<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\IncomeResource\Pages\ListIncomes;
use App\Filament\Resources\IncomeResource\Pages\CreateIncome;
use App\Filament\Resources\IncomeResource\Pages\ViewIncome;
use App\Filament\Resources\IncomeResource\Pages\EditIncome;
use App\Filament\Resources\IncomeResource\Pages;
use App\Filament\Resources\IncomeResource\RelationManagers;
use App\Models\Income;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Leandrocfe\FilamentPtbrFormFields\Money;

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;
    protected static ?string $navigationLabel = 'Receitas';
    protected static string | \UnitEnum | null $navigationGroup = 'Receitas';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Receitas';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(fn () => Filament::auth()->user()->id)
                    ->required(),
                Select::make('wallet_id')
                    ->label('Carteira')
                    ->placeholder('Selecione uma carteira')
                    ->relationship('wallet', 'name')
                    ->required(),
                Select::make('income_category_id')
                    ->label('Categoria')
                    ->placeholder('Selecione categoria')
                    ->relationship('category', 'name')
                    ->required(),
                DatePicker::make('date')
                    ->label('Data')
                    ->required(),
                Money::make('amount')
                    ->label('Valor')
                    ->default('00,00')
                    ->required(),
                TextInput::make('description')
                    ->label('Descrição')
                    ->columnSpan('full')
                    ->maxLength(65535),
                Checkbox::make('is_recurring')
                    ->label('É recorrente?')
                    ->reactive()
                    ->default(fn (?Model $record ) => $record?->recurrence !== null),
                Fieldset::make('Recorrência')
                    ->schema([
                        Select::make('frequency')
                            ->label('Frequência')
                            ->options([
                                'daily' => 'Diariamente',
                                'weekly' => 'Semanalmente',
                                'monthly' => 'Mensalmente',
                                'yearly' => 'Anualmente',
                            ])
                            ->requiredIf('is_recurring', true),
                        DatePicker::make('starts_at')
                            ->label('Data de Início')
                            ->requiredIf('is_recurring', true),
                        DatePicker::make('ends_at')
                            ->label('Data de Fim'),
                    ])
                    ->columns(2)
                    ->visible(fn (Get $get): bool => $get('is_recurring')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label('Descrição')
                    ->limit(50)
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('wallet.name')
                    ->label('Carteira')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('date')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL', true)
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIncomes::route('/'),
            'create' => CreateIncome::route('/create'),
            'view' => ViewIncome::route('/{record}'),
            'edit' => EditIncome::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['recurrency_data'] = $data['recurrency'] ?? null;
        unset($data['recurrency']);

        return $data;
    }

    public static function afterCreate($record, array $data): void
    {
        if (!empty($data['is_recurrent']) && isset($data['recurrency_data'])) {
            $record->recurrency()->create([
                'frequency' => $data['recurrency_data']['frequency'],
                'end_date' => $data['recurrency_data']['end_date'],
            ]);
        }
        dd($record);
        if ($record->id) {

//            $start = Carbon::parse($record->starts_at);
//            $end = Carbon::parse($record->ends_at);
//            $current = $start->copy();
//
//            while ($current <= $end) {
//                Parcel::create([
//                    'income_id' => $income->id,
//                    'recurrence_id' => $record->id,
//                ]);
//            }
        }
    }
}
