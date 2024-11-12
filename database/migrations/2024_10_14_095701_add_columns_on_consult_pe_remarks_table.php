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
        Schema::table('consult_pe_remarks', function (Blueprint $table) {
            $table->text('conjunctiva_remarks')->after('genitourinary_remarks')->nullable();
            $table->text('neck_remarks')->after('conjunctiva_remarks')->nullable();
            $table->text('speculum_remarks')->after('neck_remarks')->nullable();
            $table->text('thorax_remarks')->after('speculum_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consult_pe_remarks', function (Blueprint $table) {
            $table->dropColumn('conjunctiva_remarks');
            $table->dropColumn('neck_remarks');
            $table->dropColumn('speculum_remarks');
            $table->dropColumn('thorax_remarks');
        });
    }
};
