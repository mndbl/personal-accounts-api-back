<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settings\AccountCategorie>
 */
class AccountCategorieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $optionsName=array('incomes','expenses','debts to pay','accounts receivable');
        $optionsType=array('balance sheet', 'profit and loss statement');
        return [
            'name'=> array_rand($optionsName),
            'type'=>array_rand($optionsType)
        ];
    }
}
