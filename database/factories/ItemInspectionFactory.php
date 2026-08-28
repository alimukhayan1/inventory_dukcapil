<?php

namespace Database\Factories;

use App\Enums\ItemCondition;
use App\Models\Item;
use App\Models\ItemInspection;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemInspection>
 */
class ItemInspectionFactory extends Factory
{
    public function definition(): array
    {
        $isFound = fake()->boolean(85);

        return [
            'item_id' => Item::factory(),
            'inspection_date' => fake()->date(),
            'is_found' => $isFound,
            'condition' => $isFound
                ? fake()->randomElement([ItemCondition::BAIK, ItemCondition::RUSAK_RINGAN, ItemCondition::RUSAK_BERAT])
                : ItemCondition::HILANG,
            'notes' => fake()->optional()->sentence(),
            'inspected_by' => User::factory(),
        ];
    }
}
