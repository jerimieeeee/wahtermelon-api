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
        Schema::table('patients', function (Blueprint $table) {
            $table->string('mothers_name')->nullable()->change();
            $table->string('mobile_number', 13)->nullable()->change();
            $table->char('religion_code', 10)->nullable()->change();
            $table->char('occupation_code', 10)->nullable()->change();
            $table->unsignedBigInteger('education_code')->nullable()->change();
            $table->char('civil_status_code', 10)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('mothers_name')->nullable(false)->change();
            $table->string('mobile_number', 13)->nullable(false)->change();
            $table->char('religion_code', 10)->nullable(false)->change();
            $table->char('occupation_code', 10)->nullable(false)->change();
            $table->unsignedBigInteger('education_code')->nullable(false)->change();
            $table->char('civil_status_code', 10)->nullable(false)->change();
        });
    }
};
