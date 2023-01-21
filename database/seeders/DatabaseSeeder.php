<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\User::factory()->create([
            'name' => 'test user',
            'email' => 'test@example.com',
            'password' => \bcrypt('password'),
        ]);
        \App\Models\User::factory()->count(40)->create();


        //make account categories

        // \App\Models\Settings\AccountCategorie::create([
        //     'name' => 'incomes',
        //     'type' => 'statement of incomes'
        // ]);

        // \App\Models\Settings\AccountCategorie::create([
        //     'name' => 'expenses',
        //     'type' => 'statement of incomes'
        // ]);
        // \App\Models\Settings\AccountCategorie::create([
        //     'name' => 'debts to pay',
        //     'type' => 'balance sheet'
        // ]);

        // \App\Models\Settings\AccountCategorie::create([
        //     'name' => 'accounts receivable',
        //     'type' => 'balance sheet'
        // ]);


        $fecha = Carbon::now();
        $fecha->sub('3 days')->calendar();
        // \App\Models\Settings\Account::create([
        //     'account_categorie_id' => 1,
        //     'name' => 'salaries',
        //     'initial_balance' => 600,
        //     'cutoff_date' => $fecha

        // ]);
        // \App\Models\Settings\Account::create([
        //     'account_categorie_id' => 2,
        //     'name' => 'rent',
        //     'initial_balance' => 500,
        //     'cutoff_date' => $fecha

        // ]);
        // \App\Models\Settings\Account::create([
        //     'account_categorie_id' => 3,
        //     'name' => 'junior',
        //     'initial_balance' => 1000,
        //     'cutoff_date' => $fecha

        // ]);
        // \App\Models\Settings\Account::create([
        //     'account_categorie_id' => 4,
        //     'name' => 'rufino',
        //     'initial_balance' => 400,
        //     'cutoff_date' => $fecha

        // ]);


        // \App\Models\Data\Register::create([
        //     'date' => $fecha,
        //     'account_id_deb' => 1,
        //     'account_id_cre' => 2,
        //     'description' => 'description',
        //     'amount' => 1000

        // ]);
        // \App\Models\Settings\Account::factory()->count(40)->create();
        // \App\Models\Data\Register::factory()->count(400)->create();
    }
}
