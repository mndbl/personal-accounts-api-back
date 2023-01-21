<?php

namespace Database\Factories\Settings;

use App\Models\Settings\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settings\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Account::class;
    public function definition()
    {
        $asingAmount = fake()->numberBetween(50, 10000);
        return [
            'account_categorie_id' => fake()->numberBetween(1, 4),
            'name' => fake()->unique()->firstName(),
            'initial_deb_balance' => $asingAmount,
            'initial_cre_balance' => $asingAmount,
            'cutoff_date' => fake()->date()
        ];
    }
}
