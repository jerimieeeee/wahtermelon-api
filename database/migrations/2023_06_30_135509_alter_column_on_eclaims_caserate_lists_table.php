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
        Schema::table('eclaims_caserate_lists', function (Blueprint $table) {
            $table->dropForeign(['program_id']);

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
        Schema::table('eclaims_caserate_lists', function (Blueprint $table) {
            $table->dropForeign(['program_desc']);

            $table->foreign('program_id')->references('id')->on('lib_pt_groups');
        });
        Schema::enableForeignKeyConstraints();
    }
};
