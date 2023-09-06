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
        Schema::table('medicine_prescriptions', function (Blueprint $table) {
            $table->string('medicine_code')->index()->nullable()->after('konsulta_medicine_code');
            $table->text('remarks')->nullable()->after('quantity_preparation');

            $table->foreign('medicine_code')->references('hprodid')->on('lib_medicines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicine_prescriptions', function (Blueprint $table) {
            $table->dropForeign(['medicine_code']);
            $table->dropColumn(['medicine_code']);
            $table->dropColumn(['remarks']);
        });
    }
};
