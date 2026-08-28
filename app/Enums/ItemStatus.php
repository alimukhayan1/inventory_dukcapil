<?php

namespace App\Enums;

enum ItemStatus: string
{
    case AKTIF = 'aktif';
    case TIDAK_AKTIF = 'tidak_aktif';
    case DALAM_PERBAIKAN = 'dalam_perbaikan';

    public function label(): string
    {
        return match ($this) {
            self::AKTIF => 'Aktif',
            self::TIDAK_AKTIF => 'Tidak Aktif',
            self::DALAM_PERBAIKAN => 'Dalam Perbaikan',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::AKTIF => 'success',
            self::TIDAK_AKTIF => 'gray',
            self::DALAM_PERBAIKAN => 'warning',
        };
    }
}
