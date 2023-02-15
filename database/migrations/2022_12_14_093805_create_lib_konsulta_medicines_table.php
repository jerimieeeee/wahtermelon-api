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
        Schema::create('lib_konsulta_medicines', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index()->unique();
            $table->string('desc')->index();
            $table->char('generic_code',10)->index();
            $table->char('salt_code',10)->index();
            $table->char('form_code',10)->index();
            $table->char('strength_code',10)->index();
            $table->char('unit_code',10)->index();
            $table->char('package_code',10)->index();
            $table->string('category')->index();

            $table->foreign('generic_code')->references('code')->on('lib_konsulta_medicine_generics');
            $table->foreign('salt_code')->references('code')->on('lib_konsulta_medicine_salts');
            $table->foreign('form_code')->references('code')->on('lib_konsulta_medicine_forms');
            $table->foreign('strength_code')->references('code')->on('lib_konsulta_medicine_strengths');
            $table->foreign('unit_code')->references('code')->on('lib_konsulta_medicine_units');
            $table->foreign('package_code')->references('code')->on('lib_konsulta_medicine_packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_konsulta_medicines');
    }
};
