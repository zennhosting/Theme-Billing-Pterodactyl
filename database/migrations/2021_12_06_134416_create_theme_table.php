<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theme', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('highlightcolor');
            $table->string('lightcolor');
            $table->string('color');
            $table->string('subcolor');
            $table->string('color4');
            $table->string('color5');
            $table->string('color6');
            $table->string('dark');
            $table->string('primary');
            $table->string('primaryhover');
            $table->string('secondary');
            $table->string('secondaryhover');
            $table->string('background');
            $table->string('input');
            $table->string('lhighlightcolor');
            $table->string('llightcolor');
            $table->string('lcolor');
            $table->string('lsubcolor');
            $table->string('lcolor4');
            $table->string('lcolor5');
            $table->string('lcolor6');
            $table->string('ldark');
            $table->string('lprimary');
            $table->string('lprimaryhover');
            $table->string('lsecondary');
            $table->string('lsecondaryhover');
            $table->string('lbackground');
            $table->string('linput');
            $table->boolean('subnavigation');
            $table->boolean('graphcard');
            $table->string('discription');
            $table->string('backgroundimage');
            $table->string('title');
            $table->timestamps();
        });

        DB::table('theme')->insert(
            array(
                'logo' => '/favicons/favicon-32x32.png',
                'highlightcolor' => '#f5f6f8',
                'lightcolor' => '#ecf0f3',
                'color' => '#D9D9D9',
                'subcolor' => '#c0bfc0',
                'color4' => '#7c8a99',
                'color5' => '#748291',
                'color6' => '#636f7d',
                'dark' => '#33383d',
                'primary' => '#3B6CDE',
                'primaryhover' => '#6493FF',
                'secondary' => '#222339',
                'secondaryhover' => '#1b1c2e',
                'background' => '#1B1C30',
                'input' => '#2A2F41',
                'lhighlightcolor' => '#33383d',
                'llightcolor' => '#636f7d',
                'lcolor' => '#748291',
                'lsubcolor' => '#7c8a99',
                'lcolor4' => '#7c8a99',
                'lcolor5' => '#7c8a99',
                'lcolor6' => '#636f7d',
                'ldark' => '#33383d',
                'lprimary' => '#3B6CDE',
                'lprimaryhover' => '#6493FF',
                'lsecondary' => '#ffffff',
                'lsecondaryhover' => '#e3e3e3',
                'lbackground' => '#F0F0F0',
                'linput' => '#d9d9d9',
                'backgroundimage' => 'none',
                'subnavigation' => 1,
                'graphcard' => 1,
                'graphcard' => 1,
                'discription' => 'Pterodactyl Panel',
                'title' => 'Pterodactyl Panel',
                'created_at' => \Carbon::now(),
            )
        );
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
