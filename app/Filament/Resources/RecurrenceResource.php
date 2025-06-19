<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecurrenceResource\Pages;
use App\Filament\Resources\RecurrenceResource\RelationManagers;
use App\Models\Recurrence;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RecurrenceResource extends Resource
{
    protected static ?string $model = Recurrence::class;
    protected static ?string $label = 'Recorrências';
    protected static ?string $navigationLabel = 'Recorrências';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Recorrências e Parcelamentos';
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['income', 'expenses']);
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('frequency')
                    ->label('Frequência')
                    ->options([
                        'once' => 'Uma vez',
                        'daily' => 'Diariamente',
                        'weekly' => 'Semanalmente',
                        'monthly' => 'Mensalmente',
                        'yearly' => 'Anualmente',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('starts_at')
                    ->label('Data de Início')
                    ->required(),
                Forms\Components\DatePicker::make('ends_at')
                    ->label('Data de Fim'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('descricao_tipo')
                    ->label('Descrição')
                    ->badge()
                    ->color(fn ($record) => $record->income_id ? 'success' : ($record->expense_id ? 'danger' : 'gray')),

                TextColumn::make('frequency')
                    ->label('Frequencia')
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        return match ($state) {
                            'once' => 'Uma vez',
                            'daily' => 'Diariamente',
                            'weekly' => 'Semanalmente',
                            'monthly' => 'Mensalmente',
                            'yearly' => 'Anualmente'
                        };
                    }),

                Tables\Columns\TextColumn::make('starts_at')
                    ->label('Inicio')
                    ->date()
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ends_at')
                    ->label('Fim')
                    ->date()
                    ->dateTime('d/m/Y')
                    ->sortable(),
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
            'index' => Pages\ListRecurrences::route('/'),
            'create' => Pages\CreateRecurrence::route('/create'),
            'view' => Pages\ViewRecurrence::route('/{record}'),
            'edit' => Pages\EditRecurrence::route('/{record}/edit'),
        ];
    }
}
