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
        Schema::table('lib_pes', function (Blueprint $table) {
            $table->integer('konsulta_pe_id')->index()->after('pe_desc')->nullable();
            $table->boolean('konsulta_library_status')->after('konsulta_pe_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lib_pes', function (Blueprint $table) {
            $table->dropColumn('konsulta_pe_id');
            $table->dropColumn('konsulta_library_status');
        });
    }
};
