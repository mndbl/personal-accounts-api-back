<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('account_categorie_id')->constrained('account_categories')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->string('name')->unique();
            $table->float('initial_deb_balance');
            $table->float('initial_cre_balance');
            $table->date('cutoff_date');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
