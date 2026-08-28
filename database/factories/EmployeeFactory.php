<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'employee_number' => fake()->unique()->numerify('NIP-########'),
            'position' => fake()->jobTitle(),
            'department' => fake()->optional()->randomElement([
                'Pelayanan', 'Administrasi', 'Umum', 'Kependudukan', 'Pencatatan Sipil',
            ]),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
