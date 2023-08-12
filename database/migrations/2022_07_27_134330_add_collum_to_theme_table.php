<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCollumToThemeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('theme', function (Blueprint $table) {
            $table->string('metacolor')->default('#3B6CDE');
            $table->boolean('infoelement')->default(1);
            $table->string('newserverlist')->default('table');
            $table->boolean('sidegraph')->default(1);
            $table->string('dangerbutton')->default('#DC2626');
            $table->string('textbutton')->default('#4E5C7E');
            $table->string('dangerbuttonhover')->default('#ff4040');
            $table->string('textbuttonhover')->default('#60709A');
            $table->string('ldangerbutton')->default('#FF4747');
            $table->string('ltextbutton')->default('#E0EFFF');
            $table->string('ldangerbuttonhover')->default('#FF5C5C');
            $table->string('ltextbuttonhover')->default('#EBF4FF');
            $table->string('longlogo')->default('/favicons/favicon-32x32.png');
            $table->string('borderradius')->default('7');
            $table->string('typealert')->default('disabled');
            $table->string('alertdescription')->default('none');
            $table->string('discord')->default('none');
            $table->string('website')->default('none');
            $table->string('billing')->default('none');
            $table->string('knowledgebase')->default('none');
            $table->string('status')->default('none');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('theme');
    }
}
