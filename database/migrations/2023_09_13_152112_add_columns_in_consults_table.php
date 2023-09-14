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
            $table->boolean('is_konsulta')->default(0)->after('consult_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consults', function (Blueprint $table) {
            $table->dropColumn('is_konsulta');
        });
    }
};
