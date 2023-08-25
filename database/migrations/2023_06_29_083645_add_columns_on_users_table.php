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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('attendant_cc_flag')->default(false)->after('remember_token');
            $table->boolean('attendant_mc_flag')->default(false)->after('attendant_cc_flag');
            $table->boolean('attendant_tb_flag')->default(false)->after('attendant_mc_flag');
            $table->boolean('attendant_ab_flag')->default(false)->after('attendant_tb_flag');
            $table->boolean('attendant_ml_flag')->default(false)->after('attendant_ab_flag');
            $table->boolean('attendant_fp_flag')->default(false)->after('attendant_ml_flag');
            $table->boolean('attendant_cv_flag')->default(false)->after('attendant_fp_flag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('attendant_cc_flag');
            $table->dropColumn('attendant_mc_flag');
            $table->dropColumn('attendant_tb_flag');
            $table->dropColumn('attendant_ab_flag');
            $table->dropColumn('attendant_ml_flag');
            $table->dropColumn('attendant_fp_flag');
            $table->dropColumn('attendant_cv_flag');
        });
    }
};
