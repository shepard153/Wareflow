<?php

namespace App\Filament\Resources;

use App\Enums\ContactType;
use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $modelLabel = 'Kontrahent';
    protected static ?string $pluralModelLabel = 'Kontrahenci';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('address'),
                Forms\Components\TextInput::make('phone'),
                Forms\Components\TextInput::make('email'),
                Forms\Components\Select::make('contact_type')
                    ->options([
                        ContactType::Sender => 'Sender',
                        ContactType::Recipient => 'Recipient',
                        ContactType::Carrier => 'Carrier',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Nazwa'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('Adres'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Telefon'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable(),
                Tables\Columns\IconColumn::make('contact_type')
                    ->label(__('Typ'))
                    ->icon(fn (string $state): string => match ($state) {
                        'sender'    => 'heroicon-o-arrow-right-start-on-rectangle',
                        'recipient' => 'heroicon-o-arrow-left-end-on-rectangle',
                        'carrier'   => 'heroicon-o-truck',
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'sender'    => 'gray',
                        'recipient' => 'warning',
                        'carrier'   => 'info',
                    })
                    ->tooltip(fn (string $state): string => match ($state) {
                        'sender'    => 'Nadawca',
                        'recipient' => 'Odbiorca',
                        'carrier'   => 'Przewoźnik',
                    }),
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
            'index' => Pages\ManageContacts::route('/'),
            'view' => Pages\ViewContact::route('/{record}'),
        ];
    }
}
