<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\WalletResource\Pages\ListWallets;
use App\Filament\Resources\WalletResource\Pages\CreateWallet;
use App\Filament\Resources\WalletResource\Pages\ViewWallet;
use App\Filament\Resources\WalletResource\Pages\EditWallet;
use App\Filament\Resources\WalletResource\Pages;
use App\Models\Wallet;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Leandrocfe\FilamentPtbrFormFields\Money;

class WalletResource extends Resource
{
    protected static ?string $model = Wallet::class;
    protected static ?string $navigationLabel = 'Carteiras';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $breadcrumb = 'Carteira';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(fn () => Filament::auth()->user()->id)
                    ->required(),
                TextInput::make('name')
                    ->label('Nome da Carteira')
                    ->placeholder('Ex: Casa, Empresa, Cartão 7890')
                    ->required()
                    ->maxLength(255),
                TextInput::make('initial_balance')
                    ->label('Valor')
                    ->prefix('R$')
                    ->extraAttributes([
                        'x-data' => '{}',
                        'x-init' => "new Cleave(\$el, {
                        numeral: true,
                        numeralThousandsGroupStyle: 'thousand',
                        numeralDecimalMark: ',',
                        delimiter: '.',
                        numeralDecimalScale: 2,
                        numeralPositiveOnly: false
                    })"
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Usuário'),
                TextColumn::make('name')->label('Nome'),
                TextColumn::make('initial_balance')->label('Saldo Inicial')->money('BRL'),
                TextColumn::make('created_at')->label('Criado em')->dateTime('d/m/Y H:i:s'),
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
            'index' => ListWallets::route('/'),
            'create' => CreateWallet::route('/create'),
            'view' => ViewWallet::route('/{record}'),
            'edit' => EditWallet::route('/{record}/edit'),
        ];
    }
}
