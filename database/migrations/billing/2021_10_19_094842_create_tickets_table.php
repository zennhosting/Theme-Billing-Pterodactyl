<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('uuid', 100)->unique();
            $table->string('subject', 250);
            $table->string('service', 250);
            $table->string('priority', 100)->default('low');
            $table->string('status', 100)->default('open');
            $table->string('assigned_to', 100)->nullable();
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
        Schema::dropIfExists('billing_tickets');
    }
}
