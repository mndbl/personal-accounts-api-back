<?php

namespace Database\Factories\Data;

use App\Models\Data\Register;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Data\Register>
 */
class RegisterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Register::class;

    public function definition()
    {
        return [
            'date' => fake()->date(),
            'account_id_deb' => fake()->numberBetween(1, 40),
            'account_id_cre' => fake()->numberBetween(1, 40),
            'description' => fake()->sentence(6),
            'amount' => fake()->numberBetween(50, 10000),
        ];
    }
}
