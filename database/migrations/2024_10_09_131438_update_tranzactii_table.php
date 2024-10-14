<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTranzactiiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tranzactii', function (Blueprint $table) {
            // Adăugăm noua coloană 'valuta_vanduta'
            $table->string('valuta_vanduta')->after('valuta_cumparata');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tranzactii', function (Blueprint $table) {
            // Revertim modificările
            $table->dropColumn('valuta_vanduta');
        });
    }
}
