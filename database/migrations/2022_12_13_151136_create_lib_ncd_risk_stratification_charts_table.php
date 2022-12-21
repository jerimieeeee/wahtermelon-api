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
        Schema::create('lib_ncd_risk_stratification_charts', function (Blueprint $table) {
            $table->id();
            $table->enum('gender', ['M', 'F', 'I']);
            $table->boolean('smoking_status');
            $table->unsignedInteger('age');
            $table->unsignedInteger('sbp');
            $table->unsignedInteger('cholesterol');
            $table->boolean('diabetes_present');
            $table->string('type');
            $table->string('color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_ncd_risk_stratification_charts');
    }
};
