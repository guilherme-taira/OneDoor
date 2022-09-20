<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTableRotas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_rotas', function (Blueprint $table) {
            $table->id();
            $table->string('id_rota');
            $table->unsignedBigInteger('cliente_id');
            $table->integer('remessa');
            $table->char('baixado')->nullable();
            $table->dateTime('dateStart')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('dateFinished')->nullable();
            $table->foreign('cliente_id')->references('id')->on('users');
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
        Schema::dropIfExists('table_rotas');
    }
}
