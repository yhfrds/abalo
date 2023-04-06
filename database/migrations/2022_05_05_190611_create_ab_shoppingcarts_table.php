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
        Schema::create('ab_shoppingcart', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('The bigIncrements method creates an auto-incrementing UNSIGNED BIGINT (primary key) equivalent column');
            $table->bigInteger('ab_creator_id')->nullable(false)->comment('Referenz auf den/die Benutzer:in, dem der Warenkorb gehört');
            $table->timestamp('ab_createdate')->default(\Carbon\Carbon::now()->toDateTimeString())->nullable(false)->comment('Zeitpunkt der Erstellung');
            $table->foreign('ab_creator_id')->references('id')->on('ab_user');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ab_shoppingcart');
    }
};
