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
        Schema::create('consult_ccdev_breastfeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ccdevs_id')->constrained();
            $table->integer('patient_id');
            $table->integer('user_id');
            $table->boolean('bfed_month1')->nullable();
            $table->boolean('bfed_month2')->nullable();
            $table->boolean('bfed_month3')->nullable();
            $table->boolean('bfed_month4')->nullable();
            $table->boolean('bfed_month5')->nullable();
            $table->boolean('bfed_month6')->nullable();
            $table->unsignedBigInteger('reason_id')->nullable();
            $table->date('ebf_date')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('reason_id')->references('reason_id')->on('lib_ebf_reasons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_ccdev_breastfeds');
    }
};
