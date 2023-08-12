<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingSubDomainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_subdomain', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('cloudflare');
            $table->integer('api_id');
            $table->integer('invoice_id');
            $table->string('a_name');
            $table->string('srv_name');
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
        Schema::dropIfExists('billing_subdomain');
    }
}
