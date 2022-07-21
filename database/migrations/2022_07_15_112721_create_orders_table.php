<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->float('value');
            $table->string('ORCNUM');
            $table->integer('quantity_items');
            $table->float('desconto')->nullable();
            $table->text('description')->nullable();
            $table->char('HORASAIDA',5)->nullable();
            $table->text('response')->nullable();
            $table->unsignedBigInteger('client_id');
            $table->char('Flag_Processado')->default('X');
            $table->char('flag_erro')->default();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
