<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre Completo')
                    ->required(),

                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),

                Select::make('role')
                    ->label('Rol del Usuario')
                    ->options([
                        'admin' => 'Administrador',
                        'user' => 'Piloto (User)',
                    ])
                    ->required(),

                TextInput::make('governance_score')
                    ->label('Puntos de Gobernanza')
                    ->numeric()
                    ->default(0),

                TextInput::make('design_score')
                    ->label('Puntos de Diseño')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
