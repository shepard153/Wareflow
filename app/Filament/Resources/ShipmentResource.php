<?php

namespace App\Filament\Resources;

use App\Enums\ShipmentStatus;
use App\Enums\ShipmentType;
use App\Filament\Resources\ShipmentResource\Pages;
use App\Http\Requests\ShipmentRequest;
use App\Models\Shipment;
use App\Rules\OutgoingShipmentItemExceedsStockQuantity;
use Filament\Forms;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;
    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $modelLabel = 'Dostawa';
    protected static ?string $pluralModelLabel = 'Dostawy';

    public static function rules(): array
    {
        return (new ShipmentRequest())->rules();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    self::shipmentDetailsStep(),
                    self::shipmentItemsStep(),
                ])->columnSpanFull()->skippable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(self::tableColumns())
            ->defaultSort('scheduled_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('warehouse_id')
                    ->label(__('Magazyn'))
                    ->relationship('warehouse', 'name'),
                Tables\Filters\SelectFilter::make('contact_id')
                    ->label(__('Kontrahent'))
                    ->relationship('contact', 'name'),
                Tables\Filters\SelectFilter::make('status')
                    ->options(ShipmentStatus::getOptions()),
                Tables\Filters\SelectFilter::make('shipment_type')
                    ->label(__('Typ'))
                    ->options(ShipmentType::getOptions()),
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Split::make([
                    self::infolistTabsSection(),
                    self::infolistAsideSection()
                ])->from('md')->columnSpanFull()
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'view'   => Pages\ViewShipment::route('/{record}'),
            'edit'   => Pages\EditShipment::route('/{record}/edit'),
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
                    ->label(__('Numer referencyjny'))
                    ->autofocus()
                    ->required()
                    ->rules(self::rules()['reference'])
                    ->unique('shipments', 'reference', ignoreRecord: true),
                Forms\Components\TextInput::make('tracking_number')
                    ->label(__('Numer przesyłki'))
                    ->rules(self::rules()['tracking_number'])
                    ->unique('shipments', 'tracking_number', ignoreRecord: true),
                Forms\Components\Select::make('shipment_type')
                    ->label(__('Typ dostawy'))
                    ->options(ShipmentType::getOptions())
                    ->disabled(fn (Shipment $shipment): bool => $shipment->id !== null)
                    ->required()
                    ->rules(self::rules()['shipment_type'])
                    ->live(),
                Forms\Components\Select::make('status')
                    ->disabled(fn (Shipment $shipment): bool => $shipment->id === null)
                    ->default(fn (Shipment $shipment): string => $shipment->id === null ? ShipmentStatus::Created : null)
                    ->live()
                    ->options(ShipmentStatus::getOptions())
                    ->required()
                    ->rules(self::rules()['status']),
                Forms\Components\Textarea::make('description')
                    ->label(__('Opis'))
                    ->rules(self::rules()['description'])
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('scheduled_date')
                    ->label(__('Data planowana'))
                    ->native(false)
                    ->required()
                    ->rules(self::rules()['scheduled_date']),
                Forms\Components\DatePicker::make('shipment_date')
                    ->label(__('Data dostawy'))
                    ->native(false)
                    ->required(fn (Get $get): bool => $get('status') === ShipmentStatus::Delivered)
                    ->rules(self::rules()['shipment_date'])
                    ->disabled(fn (Shipment $shipment, Get $get): bool => $shipment->id === null
                        && $shipment->status !== ShipmentStatus::Delivered
                        || $get('status') !== ShipmentStatus::Delivered
                    ),
                Forms\Components\Select::make('contact_id')
                    ->label(__('Kontrahent'))
                    ->relationship('contact', 'name')
                    ->required()
                    ->rules(self::rules()['contact_id']),
                Forms\Components\Select::make('warehouse_id')
                    ->label(__('Magazyn dostawy'))
                    ->relationship('warehouse', 'name')
                    ->required()
                    ->rules(self::rules()['warehouse_id']),
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
                    ->disabled(fn (Get $get): bool => $get('status') !== ShipmentStatus::Created)
                    ->schema(fn (Get $get): array => self::getShipmentItemsFormSchema($get))
                    ->columns(2)
                    ->addActionLabel(__('Dodaj kolejną pozycję'))
            ]);
    }

    /**
     * @param Get $get
     * @return array
     */
    private static function getShipmentItemsFormSchema(Get $get): array
    {
        $productIdField = Forms\Components\Select::make('product_id')
                ->label(__('Produkt'))
                ->searchable()
                ->options(
                    fn (): array => \App\Models\Product::all()->pluck('name', 'id')->toArray()
                )
                ->required()
                ->rules(self::rules()['shipmentItems.*.product_id']);

        if ($get('shipment_type') === ShipmentType::Outgoing) {
            $quantityField = Forms\Components\TextInput::make('quantity')
                ->label(__('Ilość'))
                ->type('number')
                ->required()
                ->rules(array_merge(
                    self::rules()['shipmentItems.*.quantity'],
                    [fn (Get $get) => new OutgoingShipmentItemExceedsStockQuantity(
                        $get('product_id')
                    )]
                ));
        } else {
            $quantityField = Forms\Components\TextInput::make('quantity')
                ->label(__('Ilość'))
                ->type('number')
                ->required()
                ->rules(self::rules()['shipmentItems.*.quantity']);
        }

        if ($get('shipment_type') === ShipmentType::Incoming) {
            return [
                $productIdField,
                $quantityField,
                Forms\Components\TextInput::make('batch_number')
                    ->label(__('Numer partii'))
                    ->rules(self::rules()['shipmentItems.*.batch_number']),
                Forms\Components\TextInput::make('barcode')
                    ->label(__('Kod kreskowy'))
                    ->rules(self::rules()['shipmentItems.*.barcode']),
                Forms\Components\DatePicker::make('expiry_date')
                    ->label(__('Data ważności (jeśli dotyczy)'))
                    ->native(false)
                    ->rules(self::rules()['shipmentItems.*.expiry_date']),
            ];
        }

        return [$productIdField, $quantityField];
    }

    /**
     * @return array
     */
    private static function tableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('warehouse.name')
                ->label(__('Magazyn'))
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('contact.name')
                ->label(__('Kontrahent'))
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('reference')
                ->label(__('Numer referencyjny'))
                ->sortable()
                ->searchable(),
            Tables\Columns\IconColumn::make('shipment_type')
                ->label(__('Typ'))
                ->icon(fn (string $state): string => ShipmentType::getIcon($state))
                ->color(fn (string $state): string => ShipmentType::getColor($state))
                ->tooltip(fn (string $state): string => ShipmentType::getLabel($state))
                ->sortable(),
            Tables\Columns\IconColumn::make('status')
                ->label(__('Status'))
                ->icon(fn (string $state): string => ShipmentStatus::getIcon($state))
                ->color(fn (string $state): string => ShipmentStatus::getColor($state))
                ->tooltip(fn (string $state): string => ShipmentStatus::getLabel($state))
                ->sortable(),
            Tables\Columns\TextColumn::make('scheduled_date')
                ->label(__('Data planowana'))
                ->sortable(),
            Tables\Columns\TextColumn::make('shipment_date')
                ->label(__('Data dostawy'))
                ->default('-')
                ->sortable(),
        ];
    }

    private static function infolistTabsSection(): Infolists\Components\Section
    {
        return Infolists\Components\Section::make([
            Infolists\Components\Tabs::make('Tabs')
                ->tabs([
                    Infolists\Components\Tabs\Tab::make('shipping_details')
                        ->label(__('Szczegóły dostawy'))
                        ->schema(self::shipmentDetailsTab())
                        ->columns(2),
                    Infolists\Components\Tabs\Tab::make('shipment_items')
                        ->label(__('Produkty'))
                        ->schema(self::shipmentItemsTab()),
                    Infolists\Components\Tabs\Tab::make('shipment_history')
                        ->label(__('Historia statusów'))
                        ->schema(self::statusHistoryTab()),
                ])
        ]);
    }

    private static function shipmentDetailsTab(): array
    {
        return [
            Infolists\Components\TextEntry::make('reference')
                ->label(__('Numer referencyjny')),
            Infolists\Components\TextEntry::make('tracking_number')
                ->label(__('Numer przesyłki'))
                ->default('-'),
            Infolists\Components\TextEntry::make('contact.name')
                ->label(__('Kontrahent')),
            Infolists\Components\TextEntry::make('warehouse.name')
                ->label(__('Magazyn dostawy')),
            Infolists\Components\TextEntry::make('description')
                ->label(__('Opis'))
                ->default('-')
                ->columnSpanFull(),
        ];
    }

    private static function shipmentItemsTab(): array
    {
        return [
            Infolists\Components\RepeatableEntry::make('shipmentItems')
                ->label(__('Lista produktów'))
                ->schema([
                    Infolists\Components\TextEntry::make('product.name')
                        ->label(__('Nazwa')),
                    Infolists\Components\TextEntry::make('product.sku')
                        ->label(__('SKU')),
                    Infolists\Components\TextEntry::make('quantity')
                        ->label(__('Ilość')),
                    Infolists\Components\TextEntry::make('batch_number')
                        ->label(__('Numer partii'))
                        ->default('-'),
                    Infolists\Components\TextEntry::make('barcode')
                        ->label(__('Kod kreskowy'))
                        ->default('-'),
                    Infolists\Components\TextEntry::make('expiry_date')
                        ->label(__('Data ważności'))
                        ->default('-'),
                ])->columns(3)
        ];
    }

    private static function statusHistoryTab(): array
    {
        return [
            Infolists\Components\RepeatableEntry::make('statusHistories')
                ->label('')
                ->schema([
                    Infolists\Components\TextEntry::make('status')
                        ->label(__('Status'))
                        ->badge()
                        ->color(fn (string $state): string => ShipmentStatus::getColor($state))
                        ->formatStateUsing(fn (string $state): string => ShipmentStatus::getLabel($state)),
                    Infolists\Components\TextEntry::make('created_at')
                        ->label(__('Data zmiany')),
                ])->columns(2),
        ];
    }

    private static function infolistAsideSection(): Infolists\Components\Section
    {
        return Infolists\Components\Section::make([
            Infolists\Components\TextEntry::make('scheduled_date')
                ->label(__('Data planowana')),
            Infolists\Components\TextEntry::make('shipment_date')
                ->label(__('Data dostawy'))
                ->default('-'),
            Infolists\Components\TextEntry::make('shipment_type')
                ->label(__('Typ dostawy'))
                ->badge()
                ->color(fn (string $state): string => ShipmentType::getColor($state))
                ->formatStateUsing(fn (string $state): string => ShipmentType::getLabel($state)),
            Infolists\Components\TextEntry::make('status')
                ->label(__('Status'))
                ->badge()
                ->color(fn (string $state): string => ShipmentStatus::getColor($state))
                ->formatStateUsing(fn (string $state): string => ShipmentStatus::getLabel($state))
        ])->grow(false);
    }
}
