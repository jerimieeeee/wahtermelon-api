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
        Schema::table('lib_medical_histories', function (Blueprint $table) {
            $table->char('konsulta_history_id', 4)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lib_medical_histories', function (Blueprint $table) {
            $table->integer('konsulta_history_id')->change();
        });
    }
};
