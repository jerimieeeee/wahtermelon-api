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
        Schema::table('household_folders', function (Blueprint $table) {
            $table->char('residence_classification_code', 10)->after('barangay_code')->index()->nullable();

            $table->foreign('residence_classification_code')->references('code')->on('lib_residence_classifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('household_folders', function (Blueprint $table) {
            $table->dropForeign(['residence_classification_code']);
            $table->dropColumn('residence_classification_code');
        });
    }
};
