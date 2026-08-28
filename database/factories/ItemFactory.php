<?php

namespace Database\Factories;

use App\Enums\ItemCondition;
use App\Enums\ItemStatus;
use App\Models\Category;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'inventory_code' => fake()->unique()->numerify('INV-####-####'),
            'serial_number' => fake()->optional()->bothify('SN-????-########'),
            'name' => fake()->words(3, true),
            'category_id' => Category::factory(),
            'brand' => fake()->optional()->company(),
            'model' => fake()->optional()->bothify('Model-??##'),
            'acquisition_year' => fake()->optional()->numberBetween(2018, 2026),
            'acquisition_price' => fake()->optional()->numberBetween(100000, 50000000),
            'room_id' => Room::factory(),
            'employee_id' => Employee::factory(),
            'condition' => fake()->randomElement(ItemCondition::cases()),
            'status' => fake()->randomElement(ItemStatus::cases()),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
