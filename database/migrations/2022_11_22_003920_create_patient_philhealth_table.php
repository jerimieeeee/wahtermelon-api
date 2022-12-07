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
        Schema::create('patient_philhealth', function (Blueprint $table) {
            $table->id();
            $table->string('philhealth_id',14)->index();
            $table->string('facility_code')->index();
            $table->foreignUuid('patient_id')->index()->constrained();
            $table->foreignUuid('user_id')->nullable()->index()->constrained();
            $table->date('enlistment_date')->index();
            $table->year('effectivity_year')->index();
            $table->foreignId('enlistment_status_id')->index()->constrained('lib_philhealth_enlistment_statuses');
            $table->char('package_type_id')->index();
            $table->char('membership_type_id')->index();
            $table->foreignId('membership_category_id')->index()->constrained('lib_philhealth_membership_categories');
            $table->string('member_pin',14)->index()->nullable();
            $table->string('member_last_name')->index()->nullable();
            $table->string('member_first_name')->index()->nullable();
            $table->string('member_middle_name')->index()->nullable();
            $table->string('member_suffix_name')->index()->nullable();
            $table->date('member_birthdate')->index()->nullable();
            $table->enum('member_gender', ['M', 'F'])->index()->nullable();
            $table->char('member_relation_id',1)->index()->nullable();
            $table->string('employer_pin',12)->index()->nullable();
            $table->string('employer_address')->index()->nullable();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('package_type_id')->references('id')->on('lib_philhealth_package_types');
            $table->foreign('member_relation_id')->references('id')->on('lib_member_relationships');
            $table->foreign('member_suffix_name')->references('code')->on('lib_suffix_names');
            $table->foreign('membership_type_id')->references('id')->on('lib_philhealth_membership_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_philhealth');
    }
};
