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
        Schema::table('consult_laboratory_syphilis', function(Blueprint $table) {
            $table->renameColumn('lab_result_code', 'findings_code');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('consult_laboratory_syphilis', function(Blueprint $table) {
            $table->renameColumn('findings_code', 'lab_result_code');
        });
        Schema::enableForeignKeyConstraints();
    }
};
