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
        Schema::create('consult_mc_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mc_id')->constrained();
            // $table->foreignId('consult_id')->constrained();
            $table->foreignUuid('patients_id')->constrained();
            $table->foreignUuid('user_id')->constrained();
            $table->char('service_id',5);
            $table->char('visit_type',10);
            $table->char('visit_status',10);
            $table->date('service_date');
            $table->integer('service_qty',false,true)->length(6)->nullable();
            $table->boolean('positive_result');
            $table->boolean('intake_penicillin');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consult_mc_services');
    }
};
