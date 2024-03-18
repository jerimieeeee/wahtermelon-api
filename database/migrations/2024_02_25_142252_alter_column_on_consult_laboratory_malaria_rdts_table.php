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
        Schema::disableForeignKeyConstraints();
        Schema::table('consult_laboratory_malaria_rdts', function(Blueprint $table) {
            $table->renameColumn('parasite_type', 'parasite_type_code');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('consult_laboratory_malaria_rdts', function(Blueprint $table) {
            $table->renameColumn('parasite_type_code', 'parasite_type');
        });
        Schema::enableForeignKeyConstraints();
    }
};
