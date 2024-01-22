<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Filament\Resources\ShipmentResource\RelationManagers;
use App\Models\Shipment;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $modelLabel = 'Dostawa';
    protected static ?string $pluralModelLabel = 'Dostawy';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    self::shipmentDetailsStep(),
                    self::shipmentItemsStep(),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::tableColumns())
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
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'view' => Pages\ViewShipment::route('/{record}'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
        ];
    }

    /**
     * @return Wizard\Step
     */
    private static function shipmentDetailsStep(): Wizard\Step
    {
        return Wizard\Step::make('shipment.details')
            ->label(__('Szczegóły dostawy'))
            ->schema([
                Forms\Components\TextInput::make('reference')
                    ->autofocus()
                    ->required()
                    ->unique('shipments', 'reference', ignoreRecord: true)
                    ->label(__('Numer referencyjny')),
                Forms\Components\TextInput::make('tracking_number')
                    ->unique('shipments', 'tracking_number', ignoreRecord: true)
                    ->label(__('Numer przesyłki')),
                Forms\Components\Select::make('shipment_type')
                    ->options([
                        'incoming'           => __('Przychodząca'),
                        'outgoing'           => __('Wychodząca'),
                        'warehouse_transfer' => __('Przesunięcie międzymagazynowe'),
                    ])
                    ->required()
                    ->label(__('Typ dostawy')),
                Forms\Components\Select::make('status')
                    ->options([
                        'created'   => __('Utworzona'),
                        'pending'   => __('Oczekująca'),
                        'on_hold'   => __('Wstrzymana'),
                        'in_transit'=> __('W transporcie'),
                        'delivered' => __('Dostarczona'),
                        'canceled'  => __('Anulowana'),
                    ])
                    ->required()
                    ->label(__('Status')),
                Forms\Components\Textarea::make('description')
                    ->label(__('Opis'))
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('scheduled_date')
                    ->native(false)
                    ->required()
                    ->label(__('Data planowana')),
                Forms\Components\DatePicker::make('shipment_date')
                    ->native(false)
                    ->label(__('Data dostawy')),
                Forms\Components\Select::make('contact_id')
                    ->relationship('contact', 'name')
                    ->required()
                    ->label(__('Kontrahent')),
                Forms\Components\Select::make('warehouse_id')
                    ->relationship('warehouse', 'name')
                    ->required()
                    ->label(__('Magazyn')),
            ])->columns(2);
    }

    /**
     * @return Wizard\Step
     */
    private static function shipmentItemsStep(): Wizard\Step
    {
        return Wizard\Step::make('shipment.items')
            ->label(__('Pozycje dostawy'))
            ->schema([
                Forms\Components\Repeater::make('shipmentItems')
                    ->label(__('Lista produktów'))
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label(__('Produkt'))
                            ->searchable()
                            ->options(
                                fn (): array => \App\Models\Product::all()->pluck('name', 'id')->toArray()
                            )
                            ->required(),
                        Forms\Components\TextInput::make('quantity')
                            ->label(__('Ilość'))
                            ->type('number')
                            ->required(),
                        Forms\Components\TextInput::make('batch_number')
                            ->label(__('Numer partii')),
                        Forms\Components\TextInput::make('barcode')
                            ->label(__('Kod kreskowy')),
                        Forms\Components\DatePicker::make('expiry_date')
                            ->label(__('Data ważności (jeśli dotyczy)'))
                            ->native(false),
                    ])
                    ->columns(2)
                    ->addActionLabel(__('Dodaj kolejną pozycję'))
            ]);
    }

    /**
     * @return array
     */
    private static function tableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('warehouse.name')
                ->label(__('Magazyn'))
                ->sortable(),
            Tables\Columns\TextColumn::make('contact.name')
                ->label(__('Kontrahent'))
                ->sortable(),
            Tables\Columns\TextColumn::make('reference')
                ->label(__('Numer referencyjny'))
                ->sortable(),
            Tables\Columns\IconColumn::make('shipment_type')
                ->label(__('Typ'))
                ->icon(fn (string $state): string => match ($state) {
                    'incoming'           => 'heroicon-o-arrow-right-start-on-rectangle',
                    'outgoing'           => 'heroicon-o-arrow-left-end-on-rectangle',
                    'warehouse_transfer' => 'heroicon-o-truck',
                })
                ->color(fn (string $state): string => match ($state) {
                    'incoming'           => 'gray',
                    'outgoing'           => 'warning',
                    'warehouse_transfer' => 'info',
                })
                ->tooltip(fn (string $state): string => match ($state) {
                    'incoming'             => __('Przychodząca'),
                    'outgoing'             => __('Wychodząca'),
                    'warehouse_transfer'   => __('Przesunięcie międzymagazynowe'),
                })
                ->sortable(),
            Tables\Columns\IconColumn::make('status')
                ->label(__('Status'))
                ->icon(fn (string $state): string => match ($state) {
                    'created'   => 'heroicon-o-clipboard',
                    'pending'   => 'heroicon-o-clock',
                    'on_hold'   => 'heroicon-o-pause',
                    'in_transit'=> 'heroicon-o-truck',
                    'delivered' => 'heroicon-o-check-circle',
                    'canceled'  => 'heroicon-o-x-circle',
                })
                ->color(fn (string $state): string => match ($state) {
                    'created'   => 'gray',
                    'pending'   => 'info',
                    'on_hold'   => 'warning',
                    'in_transit'=> 'primary',
                    'delivered' => 'success',
                    'canceled'  => 'danger',
                })
                ->tooltip(fn (string $state): string => match ($state) {
                    'created'   => __('Utworzona'),
                    'pending'   => __('Oczekująca'),
                    'on_hold'   => __('Wstrzymana'),
                    'in_transit'=> __('W transporcie'),
                    'delivered' => __('Dostarczona'),
                    'canceled'  => __('Anulowana'),
                })
                ->sortable(),
            Tables\Columns\TextColumn::make('shipment_date')
                ->label(__('Data dostawy'))
                ->sortable(),
            Tables\Columns\TextColumn::make('scheduled_date')
                ->label(__('Data planowana'))
                ->sortable()
        ];
    }
}
