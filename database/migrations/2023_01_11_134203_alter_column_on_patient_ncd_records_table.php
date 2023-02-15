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
        Schema::table('patient_ncd_records', function (Blueprint $table) {
            $table->unsignedBigInteger('sensation_feet')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_ncd_records', function (Blueprint $table) {
            $table->unsignedBigInteger('sensation_feet')->nullable(false)->change();
        });
    }
};
