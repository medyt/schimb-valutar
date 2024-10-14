<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateSchimbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_schimb', function (Blueprint $table) {
            $table->id();
            $table->string('valuta', 3);          // Ex: EUR, USD, GBP
            $table->string('denumire_valuta');    // Denumire completă: Euro, Dolar american etc.
            $table->decimal('oficial', 10, 4);    // Curs oficial
            $table->decimal('cumparare', 10, 4);  // Curs cumpărare
            $table->decimal('vanzare', 10, 4);    // Curs vânzare
            $table->decimal('paritate', 10, 4);   // Paritate
            $table->timestamps();                 // Timpul de creare/modificare
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rate_schimb');
    }
}