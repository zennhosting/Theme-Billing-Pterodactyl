<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingAffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_affiliates', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unique();
			$table->string('code', 50)->unique();
			$table->integer('creator_commision');
			$table->integer('discount');
            $table->float('total_earned');
			$table->integer('clicks');
            $table->integer('purchases');
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
        Schema::dropIfExists('billing_affiliates');
    }
}
