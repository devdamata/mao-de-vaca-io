<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\RecurrenceResource\Pages\ListRecurrences;
use App\Filament\Resources\RecurrenceResource\Pages\CreateRecurrence;
use App\Filament\Resources\RecurrenceResource\Pages\ViewRecurrence;
use App\Filament\Resources\RecurrenceResource\Pages\EditRecurrence;
use App\Filament\Resources\RecurrenceResource\Pages;
use App\Filament\Resources\RecurrenceResource\RelationManagers;
use App\Models\Recurrence;
use Filament\Forms;
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
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return 'Recorrências e Parcelamentos';
    }


    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['income', 'expenses']);
    }
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('frequency')
                    ->label('Frequência')
                    ->options([
                        'once' => 'Uma vez',
                        'daily' => 'Diariamente',
                        'weekly' => 'Semanalmente',
                        'monthly' => 'Mensalmente',
                        'yearly' => 'Anualmente',
                    ])
                    ->required(),
                DatePicker::make('starts_at')
                    ->label('Data de Início')
                    ->required(),
                DatePicker::make('ends_at')
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

                TextColumn::make('starts_at')
                    ->label('Inicio')
                    ->date()
                    ->dateTime('d/m/Y')
                    ->sortable(),
                TextColumn::make('ends_at')
                    ->label('Fim')
                    ->date()
                    ->dateTime('d/m/Y')
                    ->sortable(),
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
            'index' => ListRecurrences::route('/'),
            'create' => CreateRecurrence::route('/create'),
            'view' => ViewRecurrence::route('/{record}'),
            'edit' => EditRecurrence::route('/{record}/edit'),
        ];
    }
}
