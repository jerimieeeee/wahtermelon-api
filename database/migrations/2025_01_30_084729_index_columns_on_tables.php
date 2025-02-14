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
        Schema::table('consult_notes_final_dxes', function(Blueprint $table)
        {
            $table->index('icd10_code');
        });

        Schema::table('consult_notes', function(Blueprint $table)
        {
            $table->index('consult_id');
        });

        Schema::table('consults', function(Blueprint $table)
        {
            $table->index('consult_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consult_notes_final_dxes', function(Blueprint $table)
        {
            $table->dropIndex(['icd10_code']);
        });

        Schema::table('consult_notes', function(Blueprint $table)
        {
            $table->dropIndex(['consult_id']);
        });

        Schema::table('consults', function(Blueprint $table)
        {
            $table->dropIndex(['consult_date']);
        });
    }
};
