<?php

namespace App\Enums;

enum MutationType: string
{
    case ROOM = 'room';
    case RESPONSIBLE_EMPLOYEE = 'responsible_employee';
    case ROOM_AND_EMPLOYEE = 'room_and_employee';

    public function label(): string
    {
        return match ($this) {
            self::ROOM => 'Pindah Ruangan',
            self::RESPONSIBLE_EMPLOYEE => 'Ganti Penanggung Jawab',
            self::ROOM_AND_EMPLOYEE => 'Pindah Ruangan & Penanggung Jawab',
        };
    }
}
