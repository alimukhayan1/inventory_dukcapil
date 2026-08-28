<?php

namespace App\Enums;

enum ItemCondition: string
{
    case BAIK = 'baik';
    case RUSAK_RINGAN = 'rusak_ringan';
    case RUSAK_BERAT = 'rusak_berat';
    case HILANG = 'hilang';

    public function label(): string
    {
        return match ($this) {
            self::BAIK => 'Baik',
            self::RUSAK_RINGAN => 'Rusak Ringan',
            self::RUSAK_BERAT => 'Rusak Berat',
            self::HILANG => 'Hilang',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::BAIK => 'success',
            self::RUSAK_RINGAN => 'warning',
            self::RUSAK_BERAT => 'danger',
            self::HILANG => 'gray',
        };
    }
}
