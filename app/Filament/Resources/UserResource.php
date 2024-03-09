<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $modelLabel = 'Użytkownik';
    protected static ?string $pluralModelLabel = 'Użytkownicy';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('Imię i nazwisko'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(User::class, 'email', ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->default('')
                    ->required(fn (User $user) => is_null($user->getKey()))
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->label(__('Rola'))
                    ->options(
                        Role::all()
                            ->mapWithKeys(fn (Role $role) => [$role->name => __($role->name)])
                            ->toArray()
                    )
                    ->required(),
                Forms\Components\FileUpload::make('avatar_url')
                    ->label(__('Avatar')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Imię i nazwisko'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label(__('Avatar')),
                Tables\Columns\TextColumn::make('role')
                    ->label(__('Rola'))
                    ->formatStateUsing(fn (string $state) => __($state))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Utworzono'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Zaktualizowano'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->action(function (array $data, User $user) {
                        if (! isset($data['password'])) {
                            unset($data['password']);
                        }

                        $user->update($data);
                        $user->assignRole($data['role']);
                    }),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
