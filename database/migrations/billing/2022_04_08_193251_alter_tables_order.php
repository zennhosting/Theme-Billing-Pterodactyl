<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablesOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('billing_plans', 'order')) {
        Schema::table('billing_plans', function (Blueprint $table) {
          $table->integer('order')->default('0');
        });
      }
      if (!Schema::hasColumn('billing_games', 'order')) {
        Schema::table('billing_games', function (Blueprint $table) {
          $table->integer('order')->default('0');
        });
      }
      if (!Schema::hasColumn('custom_pages', 'order')) {
        Schema::table('custom_pages', function (Blueprint $table) {
          $table->integer('order')->default('0');
        });
      }
      if (!Schema::hasColumn('billing_plans', 'discount')) {
        Schema::table('billing_plans', function (Blueprint $table) {
          $table->integer('discount')->default('0');
        });
      }
      if (!Schema::hasColumn('billing_plans', 'subdomain')) {
        Schema::table('billing_plans', function (Blueprint $table) {
          $table->integer('subdomain')->default('0');
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
