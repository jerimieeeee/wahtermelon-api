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
        Schema::table('patient_vaccines', function (Blueprint $table) {
            $table->index('vaccine_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_vaccines', function (Blueprint $table) {
            $table->dropIndex(['vaccine_date']);
        });
    }
};
