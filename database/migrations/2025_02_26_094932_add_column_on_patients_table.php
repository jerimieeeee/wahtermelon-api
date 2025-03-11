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
        Schema::table('patients', function (Blueprint $table) {
            $table->char('immunization_status', 10)->after('consent_flag')->nullable()->index();
            $table->date('immunization_date')->after('immunization_status')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropIndex(['immunization_status']);
            $table->dropIndex(['immunization_date']);
            $table->dropColumn('immunization_status');
            $table->dropColumn('immunization_date');
        });
    }
};
