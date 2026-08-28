<?php

namespace Database\Factories;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ActivityLog>
 */
class ActivityLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'action' => fake()->randomElement([
                'CREATE_ITEM', 'UPDATE_ITEM', 'DELETE_ITEM',
                'CREATE_MUTATION', 'CREATE_INSPECTION',
                'CREATE_USER', 'UPDATE_USER',
            ]),
            'subject_type' => null,
            'subject_id' => null,
            'description' => fake()->sentence(),
            'ip_address' => fake()->ipv4(),
        ];
    }
}
