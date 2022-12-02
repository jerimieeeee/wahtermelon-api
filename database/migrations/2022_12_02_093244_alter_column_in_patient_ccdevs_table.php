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
        Schema::table('patient_ccdevs', function (Blueprint $table) {
            $table->string('nbs_filter', 50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_ccdevs', function (Blueprint $table) {
            $table->string('nbs_filter', 50)->nullable(false)->change();
        });
    }
};
