<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServerCoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_cores', function (Blueprint $table) {
          $table->id();
          $table->string('server')->nullable();
          $table->string('name')->nullable();
          $table->string('core')->nullable();
          $table->string('version')->nullable();
          $table->integer('autoupdate')->default('0');
          $table->text('data')->nullable();
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
        Schema::dropIfExists('server_cores');
    }
}
