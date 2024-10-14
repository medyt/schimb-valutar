<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranzactiiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tranzactii', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('residency');
            $table->string('valuta');
            $table->decimal('suma', 10, 2);
            $table->string('document');
            $table->string('document_number');
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
        Schema::dropIfExists('tranzactii');
    }
}
