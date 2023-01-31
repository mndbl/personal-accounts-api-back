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
        Schema::create('registers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date');
            $table->foreignId('account_id_deb')->constrained('accounts')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('account_id_cre')->constrained('accounts')
            ->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('description',100);
            $table->float('amount')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registers');
    }
};
