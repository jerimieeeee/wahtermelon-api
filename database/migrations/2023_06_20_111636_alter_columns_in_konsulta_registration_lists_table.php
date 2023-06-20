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
        Schema::table('konsulta_registration_lists', function (Blueprint $table) {
            $table->string('mobile_number', 50)->change();
            $table->string('landline_number', 50)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsulta_registration_lists', function (Blueprint $table) {
            $table->string('mobile_number', 12)->change();
            $table->string('landline_number', 12)->change();
        });
    }
};
