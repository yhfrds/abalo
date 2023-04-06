<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ab_article_has_articlecategory', function (Blueprint $table) {
            $table->id();
            //$table->timestamps();

            $table->bigInteger('ab_articlecategory_id')->nullable(false)
                ->comment('Referenz auf eine Artikelkategorie');
            $table->foreign('ab_articlecategory_id')->on('ab_articlecategory')->references('id');

            $table->bigInteger('ab_article_id')->nullable(false)
                ->comment('Referenz auf einen Artikel');
            $table->foreign('ab_article_id')->on('ab_article')->references('id');

            $table->unique(['ab_articlecategory_id','ab_article_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ab_article_has_articlecategory');
    }
};
