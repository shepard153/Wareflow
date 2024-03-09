<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseResource\Pages;
use App\Models\Warehouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Magazyn';
    protected static ?string $pluralModelLabel = 'Magazyny';
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('manager_id')
                    ->label(__('Kierownik magazynu'))
                    ->relationship('manager', 'name'),
                Forms\Components\TextInput::make('name')
                    ->label(__('Nazwa magazynu'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('location')
                    ->label(__('Lokalizacja'))
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('manager.name')
                    ->label(__('Kierownik magazynu'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Nazwa magazynu'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('location')
                    ->label(__('Lokalizacja'))
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }

                        return $state;
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageWarehouses::route('/'),
        ];
    }    
}
