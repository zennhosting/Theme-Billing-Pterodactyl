<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_plans', function (Blueprint $table) {
          $table->id();

          $table->string('name', 100);
          $table->float('price');
          $table->string('icon')->nullable();
          $table->string('cpu_model')->nullable();
          $table->integer('game_id');
          $table->integer('egg');
          $table->integer('days')->nullable();
          $table->integer('cpu_limit')->nullable();
          $table->integer('memory');
          $table->integer('disk_space');
          $table->integer('database_limit')->nullable();
          $table->integer('allocation_limit')->nullable();
          $table->integer('backup_limit')->nullable();
          $table->text('description')->nullable();
          $table->text('variable')->nullable();
          $table->integer('plugins')->default('0');
          $table->integer('node');
          $table->integer('limit');
          $table->integer('order')->default('0');
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
        Schema::dropIfExists('billing_plans');
    }
}
