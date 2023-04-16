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
        Schema::create('patient_menstrual_histories', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('facility_code')->index();
            $table->double('menarche')->nullable();
            $table->date('lmp')->nullable();
            $table->double('period_duration')->nullable();
            $table->double('cycle')->nullable();
            $table->double('pads_per_day')->nullable();
            $table->double('onset_sexual_intercourse')->nullable();
            $table->string('method')->index()->constrained();
            $table->boolean('menopause')->nullable();
            $table->double('menopause_age')->nullable();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('method')->references('id')->on('lib_fp_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_menstrual_histories');
    }
};
