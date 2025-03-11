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
        Schema::table('consult_ncd_risk_assessment', function (Blueprint $table) {
            $table->boolean('diabetes_old_case')->after('age')->default(0)->index();
            $table->boolean('hypertensive_old_case')->after('age')->default(0)->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consult_ncd_risk_assessment', function (Blueprint $table) {
            $table->dropIndex(['diabetes_old_case']);
            $table->dropIndex(['hypertensive_old_case']);

            $table->dropColumn('diabetes_old_case');
            $table->dropColumn('hypertensive_old_case');
        });
    }
};
