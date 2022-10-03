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
        Schema::create('ccdevs', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->integer('user_id');
            $table->decimal('birth_weight');
            $table->string('delivery_location', 10);
            $table->string('vaccine_remarks', 255);
            $table->dateTime('ccdev_dob');
            $table->date('civil_registry_date');
            $table->date('visit_date');
            $table->integer('type_of_birth');
            $table->integer('birth_order');
            $table->integer('birth_order_multiple');
            $table->integer('mothers_id');
            $table->string('ccdev_remakrs');
            $table->boolean('ccdev_ended');
            $table->dateTime('admission_date');
            $table->dateTime('discharge_date');
            $table->string('nbs_filter', 50);
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
        Schema::dropIfExists('ccdevs');
    }
};
