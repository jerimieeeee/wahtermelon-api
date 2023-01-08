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
        Schema::create('konsulta_registration_lists', function (Blueprint $table) {
            $table->id();
            $table->string('facility_code')->index();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('custom_id')->index()->unique();
            $table->string('philhealth_id',14)->index();
            $table->string('last_name')->index()->nullable();
            $table->string('first_name')->index()->nullable();
            $table->string('middle_name')->index()->nullable();
            $table->string('suffix_name')->index()->nullable();
            $table->date('birthdate')->index()->nullable();
            $table->char('gender', 1)->index()->nullable();
            $table->char('membership_type_id')->index();
            $table->string('member_pin',14)->index()->nullable();
            $table->string('member_last_name')->index()->nullable();
            $table->string('member_first_name')->index()->nullable();
            $table->string('member_middle_name')->index()->nullable();
            $table->string('member_suffix_name')->index()->nullable();
            $table->date('member_birthdate')->index()->nullable();
            $table->char('member_gender', 1)->index()->nullable();
            $table->string('mobile_number',12)->index()->nullable();
            $table->string('landline_number',12)->index()->nullable();
            $table->string('member_category',10)->index()->nullable();
            $table->string('member_category_desc',50)->index()->nullable();
            $table->char('package_type_id')->index();
            $table->date('assigned_date')->index();
            $table->foreignId('assigned_status_id')->index()->constrained('lib_philhealth_enlistment_statuses');
            $table->year('effectivity_year')->index();
            $table->timestamps();

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
        Schema::dropIfExists('konsulta_registration_lists');
    }
};
