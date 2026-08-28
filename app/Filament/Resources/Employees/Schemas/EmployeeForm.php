<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pegawai')
                    ->schema([
                        TextInput::make('employee_number')
                            ->label('NIP / NIK')
                            ->maxLength(100)
                            ->unique(ignoreRecord: true),
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('position')
                            ->label('Jabatan')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('department')
                            ->label('Bagian / Bidang')
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
