<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique();
						$table->string('address', 255)->nullable();
						$table->string('city', 255)->nullable();
						$table->string('country', 255)->nullable();
						$table->string('postal_code', 255)->nullable();
            $table->float('balance');
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
        Schema::dropIfExists('billing_users');
    }
}
