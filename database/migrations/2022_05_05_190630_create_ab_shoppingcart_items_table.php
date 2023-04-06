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
        Schema::create('ab_shoppingcart_item', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('The bigIncrements method creates an auto-incrementing UNSIGNED BIGINT (primary key) equivalent column');
            $table->bigInteger('ab_shoppingcart_id')->nullable(false)->comment('Referenz auf den Warenkorb');
            $table->bigInteger('ab_article_id')->nullable(false)->comment('Referenz auf den Artikel');
            $table->timestamp('ab_createdate')->default(\Carbon\Carbon::now()->toDateTimeString())->nullable(false)->comment('Zeitpunkt der Erstellung');

            $table->foreign('ab_shoppingcart_id')
                ->references('id')
                ->on('ab_shoppingcart')
                ->onDelete('cascade');

            $table->foreign('ab_article_id')->references('id')->on('ab_article')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ab_shoppingcart_item');
    }
};
