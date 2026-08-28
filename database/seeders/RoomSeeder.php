<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['code' => 'KPL-01', 'name' => 'Ruang Kepala', 'description' => 'Ruangan kepala kantor cabang'],
            ['code' => 'PEL-01', 'name' => 'Ruang Pelayanan', 'description' => 'Ruangan pelayanan masyarakat'],
            ['code' => 'ADM-01', 'name' => 'Ruang Administrasi', 'description' => 'Ruangan administrasi umum'],
            ['code' => 'ARS-01', 'name' => 'Ruang Arsip', 'description' => 'Ruangan penyimpanan arsip dan dokumen'],
            ['code' => 'SRV-01', 'name' => 'Ruang Server', 'description' => 'Ruangan server dan perangkat jaringan'],
            ['code' => 'GDG-01', 'name' => 'Gudang', 'description' => 'Gudang penyimpanan barang'],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
