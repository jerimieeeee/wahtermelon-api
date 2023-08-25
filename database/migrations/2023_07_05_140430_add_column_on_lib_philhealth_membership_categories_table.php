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
        Schema::table('lib_philhealth_membership_categories', function (Blueprint $table) {
            $table->string('philhealth_cat_id', 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lib_philhealth_membership_categories', function (Blueprint $table) {
            $table->dropColumn('philhealth_cat_id');
        });
    }
};
