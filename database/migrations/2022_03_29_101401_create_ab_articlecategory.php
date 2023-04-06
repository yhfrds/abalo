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
        Schema::create('ab_articlecategory', function (Blueprint $table) {
            $table->id();
            //$table->timestamps();

            $table->string('ab_name',100)->nullable(false)->unique()
                ->comment('Name');

            $table->string('ab_description',100)->nullable()
                ->comment('Beschreibung');

            $table->bigInteger('ab_parent')->nullable(true)
                ->comment('Referenz auf die mögliche Elternkategorie. Artikelkategorien sind hierarchisch organisiert. Eine Kategorie kann beliebig viele Kind Kategorien haben. Eine Kategorie kann nur eine Elternkategorie besitzen. NULL, falls es keine Elternkategorie gibt und es sich um eine Wurzelkategorie handelt');

            $table->foreign('ab_parent')->on('ab_articlecategory')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ab_articlecategory');
    }
};
