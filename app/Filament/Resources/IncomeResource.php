<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeResource\Pages;
use App\Filament\Resources\IncomeResource\RelationManagers;
use App\Models\Income;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Leandrocfe\FilamentPtbrFormFields\Money;

class IncomeResource extends Resource
{
    protected static ?string $model = Income::class;
    protected static ?string $navigationLabel = 'Receitas';
    protected static ?string $navigationGroup = 'Receitas';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(fn () => Filament::auth()->user()->id)
                    ->required(),
                Forms\Components\Select::make('wallet_id')
                    ->label('Carteira')
                    ->placeholder('Selecione uma carteira')
                    ->relationship('wallet', 'name')
                    ->required(),
                Forms\Components\Select::make('income_category_id')
                    ->label('Categoria de Renda')
                    ->placeholder('Selecione categoria')
                    ->relationship('category', 'name')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->label('Data')
                    ->required(),
                Money::make('amount')
                    ->label('Valor')
                    ->default('00,00')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->label('Descrição')
                    ->columnSpan('full')
                    ->maxLength(65535),
                Forms\Components\Checkbox::make('is_recurring')
                    ->label('É recorrente?')
                    ->reactive()
                    ->default(fn (?Model $record ) => $record?->recurrence !== null),
                Forms\Components\Fieldset::make('Recorrência')
                    ->schema([
                        Forms\Components\Select::make('frequency')
                            ->label('Frequência')
                            ->options([
                                'daily' => 'Diariamente',
                                'weekly' => 'Semanalmente',
                                'monthly' => 'Mensalmente',
                                'yearly' => 'Anualmente',
                            ])
                            ->requiredIf('is_recurring', true),
                        Forms\Components\DatePicker::make('starts_at')
                            ->label('Data de Início')
                            ->requiredIf('is_recurring', true),
                        Forms\Components\DatePicker::make('ends_at')
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
                Tables\Columns\TextColumn::make('description')
                    ->label('Descrição')
                    ->limit(50)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('wallet.name')
                    ->label('Carteira')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL', true)
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListIncomes::route('/'),
            'create' => Pages\CreateIncome::route('/create'),
            'view' => Pages\ViewIncome::route('/{record}'),
            'edit' => Pages\EditIncome::route('/{record}/edit'),
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
