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
        Schema::create('household_folders', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('address')->index();
            $table->string('barangay_code')->index();
            $table->date('cct_date')->nullable()->index();
            $table->char('cct_id', 20)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
            $table->foreign('barangay_code')->references('code')->on('barangays');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('household_folders');
    }
};
