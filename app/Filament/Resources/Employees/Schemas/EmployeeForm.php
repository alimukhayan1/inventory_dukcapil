<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('employee_number')
                    ->default(null),
                TextInput::make('position')
                    ->required(),
                TextInput::make('department')
                    ->default(null),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
