<?php

namespace Database\Factories;

use App\Enums\EngagementStatus;
use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Engagement>
 */
class EngagementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'financial_year_end' => $this->faker->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
            'contact_name' => $this->faker->name,
            'contact_email' => $this->faker->email,
            'contact_phone' => $this->faker->phoneNumber,
            'status' => $this->faker->randomElement([EngagementStatus::ACTIVE, EngagementStatus::COMPLETED, EngagementStatus::ARCHIVED]),
            'created_by' => User::factory(),
        ];
    }
}