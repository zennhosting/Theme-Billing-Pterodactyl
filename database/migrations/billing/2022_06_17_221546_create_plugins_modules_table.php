<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePluginsModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plugins_modules', function (Blueprint $table) {
            $table->id();
            $table->string('server')->nullable();
            $table->string('name')->nullable();
            $table->integer('pl_id')->nullable();
            $table->integer('ver_id')->nullable();
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
        Schema::dropIfExists('plugins_modules');
    }
}
