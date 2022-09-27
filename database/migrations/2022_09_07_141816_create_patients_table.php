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
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->foreignId('facility_id')->nullable()->constrained();
            $table->unsignedBigInteger('old_id')->nullable();
            $table->string('last_name')->index();
            $table->string('first_name')->index();
            $table->string('middle_name')->index()->nullable();
            $table->string('suffix_name');
            $table->date('birthdate')->index();
            $table->string('mothers_name');
            $table->enum('gender', ['M', 'F']);
            $table->string('mobile_number', 13);
            $table->char('pwd_type_code')->default('NA');
            $table->boolean('indegenous_flag')->default(0);
            $table->char('blood_type_code', 3)->default('NA');
            $table->char('religion_code', 10);
            $table->char('occupation_code', 10);
            $table->unsignedBigInteger('education_code');
            $table->char('civil_status_code', 10);
            $table->boolean('consent_flag')->default(0);
            $table->string('image_url')->nullable();
            $table->timestamps();

            $table->foreign('suffix_name')->references('code')->on('lib_suffix_names');
            $table->foreign('pwd_type_code')->references('code')->on('lib_pwd_types');
            $table->foreign('religion_code')->references('code')->on('lib_religions');
            $table->foreign('occupation_code')->references('code')->on('lib_occupations');
            $table->foreign('education_code')->references('code')->on('lib_education');
            $table->foreign('civil_status_code')->references('code')->on('lib_civil_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
