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
        Schema::table('lib_dental_medical_histories', function (Blueprint $table) {
            $table->string('column_name')->after('desc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lib_dental_medical_histories', function (Blueprint $table) {
            $table->dropColumn('column_name');
        });
    }
};
