<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            ['name' => 'Budi Santoso', 'employee_number' => 'NIP-19800101', 'position' => 'Kepala Cabang', 'department' => 'Pimpinan'],
            ['name' => 'Siti Rahayu', 'employee_number' => 'NIP-19850215', 'position' => 'Staf Pelayanan', 'department' => 'Pelayanan'],
            ['name' => 'Ahmad Hidayat', 'employee_number' => 'NIP-19900320', 'position' => 'Staf Administrasi', 'department' => 'Administrasi'],
            ['name' => 'Dewi Lestari', 'employee_number' => 'NIP-19880710', 'position' => 'Staf Kependudukan', 'department' => 'Kependudukan'],
            ['name' => 'Rudi Hermawan', 'employee_number' => 'NIP-19920505', 'position' => 'Operator IT', 'department' => 'Umum'],
            ['name' => 'Rina Wulandari', 'employee_number' => 'NIP-19870825', 'position' => 'Staf Pencatatan Sipil', 'department' => 'Pencatatan Sipil'],
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
