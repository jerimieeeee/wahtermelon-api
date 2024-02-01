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
        Schema::table('facilities', function (Blueprint $table) {
            $table->string('region_code')->nullable(1)->change();
            $table->string('province_code')->nullable(1)->change();
            $table->string('municipality_code')->nullable(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facilities', function (Blueprint $table) {
            $table->string('region_code')->nullable(0)->change();
            $table->string('province_code')->nullable(0)->change();
            $table->string('municipality_code')->nullable(0)->change();
        });
    }
};
