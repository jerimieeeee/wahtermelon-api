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
        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->dropForeign(['disclosed_relation_id']);

            $table->foreign('disclosed_relation_id')->references('id')->on('lib_gbv_child_relations');
            // $table->foreignId('disclosed_relation_id')->constrained('lib_gbv_child_relations');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('patient_gbv_interviews', function (Blueprint $table) {
            $table->dropForeign(['disclosed_relation_id']);
            $table->foreign('disclosed_relation_id')->references('id')->on('lib_gbv_disclosed_types');
            // $table->foreignId(['disclosed_relation_id'])->constrained('lib_gbv_disclosed_types');
        });
        Schema::enableForeignKeyConstraints();
    }
};
