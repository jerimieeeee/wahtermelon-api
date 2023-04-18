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
        Schema::table('patient_tb_pes', function (Blueprint $table) {
            $table->foreignUlid('patient_tb_id')->after('id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient_tb_pes', function (Blueprint $table) {
            $table->dropForeign('patient_tb_pes_patient_tb_id_foreign');
            $table->dropColumn('patient_tb_id');
        });
    }
};
