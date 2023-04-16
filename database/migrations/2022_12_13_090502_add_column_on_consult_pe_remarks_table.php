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
        Schema::table('consult_pe_remarks', function (Blueprint $table) {
            $table->string('abdomen_remarks')->nullable()->after('heart_remarks');
            $table->string('extremities_remarks')->nullable()->after('abdomen_remarks');
            $table->string('breast_remarks')->nullable()->after('extremities_remarks');
            $table->string('pelvic_remarks')->nullable()->after('breast_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_pe_remarks', function (Blueprint $table) {
            $table->dropColumn('abdomen_remarks');
            $table->dropColumn('extremities_remarks');
            $table->dropColumn('breast_remarks');
            $table->dropColumn('pelvic_remarks');
        });
    }
};
