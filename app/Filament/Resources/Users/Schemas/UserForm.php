<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('organization_id')
                    ->label('Організація')
                    ->relationship('organization', 'name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->maxValue(255)
                    ->email()
                    ->unique('users', 'email')
                    ->required(),
                TextInput::make('name')
                    ->label('Прізвище, ім`я, по батькові')
                    ->maxValue(255)
                    ->required(),
                TextInput::make('rank')
                    ->label('Звання')
                    ->required(),
                TextInput::make('password')
                    ->label('Пароль')
                    ->password()
                    ->required(),
                Select::make('status_id')
                    ->label('Статус')
                    ->relationship('status', 'name')
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->label('Email верифіковано'),
                TextInput::make('metadata')
                    ->label('Метадані')
                    ->default('{}'),
                DateTimePicker::make('last_login_at')
                    ->label('Останній вхід'),
            ]);
    }
}
