<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case PETUGAS = 'petugas';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::PETUGAS => 'Petugas',
        };
    }
}
