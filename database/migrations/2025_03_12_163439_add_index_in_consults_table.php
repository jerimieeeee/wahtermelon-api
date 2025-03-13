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
        Schema::table('consults', function (Blueprint $table) {
            // $table->index('transmittal_number');
            // $table->index('pt_group');
            // $table->index('is_konsulta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consults', function (Blueprint $table) {
            // $table->dropIndex(['transmittal_number']);
            // $table->dropIndex(['pt_group']);
            // $table->dropIndex(['is_konsulta']);
        });
    }
};
