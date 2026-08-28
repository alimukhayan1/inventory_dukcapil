<?php

namespace Database\Factories;

use App\Enums\MutationType;
use App\Models\Employee;
use App\Models\Item;
use App\Models\ItemMutation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ItemMutation>
 */
class ItemMutationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'item_id' => Item::factory(),
            'mutation_type' => MutationType::ROOM,
            'from_room_id' => Room::factory(),
            'to_room_id' => Room::factory(),
            'from_employee_id' => null,
            'to_employee_id' => null,
            'mutation_date' => fake()->date(),
            'description' => fake()->optional()->sentence(),
            'created_by' => User::factory(),
        ];
    }
}
