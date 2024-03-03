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
        Schema::dropIfExists('ingredientes');
        Schema::create('ingredientes', function (Blueprint $table) {
            $table->id();
                //Opciones de tabla
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->tinyInteger('idComida')->unsigned();
            $table->foreign('idComida')
                ->references('id')
                ->on('comidas')->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('ingredientes');
            $table->integer('cantidad');
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
        Schema::dropIfExists('ingredientes');
    }
};
