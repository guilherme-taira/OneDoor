<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterHoraEntrega extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders',function(Blueprint $table) {
            $table->dateTime('dataHoraEntrega')->nullable();
            $table->string('cupomFiscal')->nullable();
            $table->char('flag_cancelado',1)->nullable();
            $table->char('flag_aguardando',1)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders',function(Blueprint $table) {
            $table->dropColumn(['dataHoraEntrega']);
            $table->dropColumn(['cupomFiscal']);
            $table->dropColumn(['flag_cancelado']);
            $table->dropColumn(['flag_aguardando']);
        });
    }
}

