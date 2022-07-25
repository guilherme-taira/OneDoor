<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentodadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamentodados', function (Blueprint $table) {
            $table->id();
            $table->string('ORCNUM');
            $table->date('data');
            $table->text('sat_chave');
            $table->char('flag_enviado',1)->default('X');
            $table->string('terminal');
            $table->integer('vendedor');
            $table->char('flag_aguardando',1)->default('X');
            $table->char('flag_finalizado',1)->nullable();
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
        Schema::dropIfExists('orcamentodados');
    }
}
