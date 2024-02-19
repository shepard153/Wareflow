<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $recordTitleAttribute = 'name';
    protected static ?string $modelLabel = 'Produkt';
    protected static ?string $pluralModelLabel = 'Produkty';
    protected static ?string $navigationIcon = 'heroicon-o-gift-top';
    protected static ?string $navigationGroup = 'Zarządzanie produktami';

    public static function rules(): array
    {
        return (new ProductRequest())->rules();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->rules(self::rules()['category_id']),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->rules(self::rules()['name']),
                Forms\Components\Textarea::make('description')
                    ->rules(self::rules()['description'])
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sku')
                    ->label('SKU')
                    ->required()
                    ->rules(self::rules()['sku']),
                Forms\Components\TextInput::make('unit_of_measure')
                    ->required()
                    ->rules(self::rules()['unit_of_measure']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('Kategoria'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Nazwa'))
                    ->description(fn (Product $record) => substr($record->getAttribute('description'), 0, 50) . '...')
                    ->tooltip(function (Product $record): ?string {
                        $description = $record->getAttribute('description');

                        if (strlen($description) <= 50) {
                            return null;
                        }

                        return $description;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unit_of_measure')
                    ->label(__('Jednostka'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('has_variants')
                    ->label(__('Warianty'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('stockQuantity.quantity')
                    ->label(__('Stan magazynowy'))
                    ->numeric()
                    ->state(fn (Product $product) => $product->getAttribute('stockItems')->sum('quantity'))
                    ->default(0),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('category.name')
                    ->label(__('Kategoria')),
                Infolists\Components\TextEntry::make('name')
                    ->label(__('Nazwa')),
                Infolists\Components\TextEntry::make('sku'),
                Infolists\Components\TextEntry::make('unit_of_measure')
                    ->label(__('Jednostka')),
                Infolists\Components\TextEntry::make('description')
                    ->label(__('Opis produktu'))
                    ->columnSpanFull(),
                Infolists\Components\RepeatableEntry::make('stockItems')
                    ->label(__('Stany magazynów'))
                    ->default(['empty'])
                    ->schema([
                        Infolists\Components\TextEntry::make('warehouse.name')
                            ->label(__('Magazyn'))
                            ->default('-'),
                        Infolists\Components\TextEntry::make('quantity')
                            ->label(__('Ilość'))
                            ->default('-'),
                    ])
                    ->columns(2)
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }    
}
