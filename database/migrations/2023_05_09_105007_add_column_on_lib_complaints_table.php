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
        Schema::table('lib_complaints', function (Blueprint $table) {
            $table->boolean('gbv_library_status')->nullable()->index()->after('konsulta_library_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lib_complaints', function (Blueprint $table) {
            $table->dropColumn('gbv_library_status');
        });
    }
};
