<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutividadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtividade', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('orcamento');
            $table->date('dataorcamento');
            $table->integer('Nvendedor');
            $table->string('orcamentohora');
            $table->text('cliente');
            $table->date('baixa')->nullable();
            $table->char('flag_baixado',1)->default('');
            $table->char('flag_separado',1)->default('');
            $table->foreign('user_id')->references('id')->on('vendedor');
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
        Schema::dropIfExists('produtividade');
    }
}
