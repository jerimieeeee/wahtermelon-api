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
        Schema::table('patient_ab_exposures', function (Blueprint $table) {
            $table->foreignId('category_id')->after('al_remarks')->on('lib_ab_categories');
            $table->boolean('unknown_animal_vaccine_flag')->after('animal_ownership_id')->default(false);
            $table->date('animal_vaccine_date')->after('unknown_animal_vaccine_flag')->nullable();
            $table->date('tandok_date')->after('tandok_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('patient_ab_exposures', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropColumn('unknown_animal_vaccine_flag');
            $table->dropColumn('animal_vaccine_date');
            $table->dropColumn('tandok_date');
        });
        Schema::enableForeignKeyConstraints();
    }
};
