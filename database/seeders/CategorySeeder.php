<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Komputer', 'description' => 'Komputer desktop dan kelengkapannya'],
            ['name' => 'Laptop', 'description' => 'Laptop dan notebook'],
            ['name' => 'Printer', 'description' => 'Printer dan mesin cetak'],
            ['name' => 'Scanner', 'description' => 'Scanner dan alat pemindai dokumen'],
            ['name' => 'Monitor', 'description' => 'Monitor dan layar tampilan'],
            ['name' => 'Furniture', 'description' => 'Meja, kursi, lemari, dan perabot kantor'],
            ['name' => 'Peralatan Jaringan', 'description' => 'Router, switch, access point, dan kabel jaringan'],
            ['name' => 'Peralatan Elektronik', 'description' => 'AC, kipas angin, dan peralatan elektronik lainnya'],
            ['name' => 'Peralatan Kantor', 'description' => 'Peralatan kantor umum lainnya'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
