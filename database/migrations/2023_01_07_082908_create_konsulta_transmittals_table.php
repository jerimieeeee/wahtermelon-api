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
        Schema::create('konsulta_transmittals', function (Blueprint $table) {
            $table->uuid('id')->index()->primary();
            $table->string('facility_code')->index();
            $table->foreignUuid('user_id')->index()->constrained();
            $table->string('transmittal_number',21)->unique()->index()->nullable();
            $table->unsignedInteger('total_enlistment')->default(0);
            $table->unsignedInteger('total_profile')->default(0);
            $table->unsignedInteger('total_soap')->default(0);
            $table->string('xml_url')->nullable();
            $table->string('konsulta_transaction_number',21)->index()->nullable();
            $table->char('xml_status', 1)->default('U');
            $table->json('xml_errors')->nullable();
            $table->timestamps();

            $table->foreign('facility_code')->references('code')->on('facilities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('konsulta_transmittals');
    }
};
