<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('eclaims_uploads', function (Blueprint $table) {
            $table->string('program_desc', 3)->after('facility_code');

            $table->foreign('program_desc')->references('id')->on('lib_pt_groups');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('eclaims_uploads', function (Blueprint $table) {
            $table->dropForeign(['program_desc']);
            $table->dropColumn('program_desc');
        });
        Schema::enableForeignKeyConstraints();
    }
};
