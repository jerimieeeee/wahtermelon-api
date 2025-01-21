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
        Schema::table('household_environmentals', function (Blueprint $table) {
            $table->dropForeign(['household_folder_id']);

            // Re-add the foreign key with cascade on delete
            $table->foreign('household_folder_id')
                ->references('id')
                ->on('household_folders')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('household_environmentals', function (Blueprint $table) {
            // Drop the updated foreign key constraint
            $table->dropForeign(['household_folder_id']);

            // Re-add the original foreign key without cascade on delete
            $table->foreign('household_folder_id')
                ->references('id')
                ->on('household_folders');
        });
    }
};
