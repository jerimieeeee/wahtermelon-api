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
        Schema::table('consult_laboratory_gene_xperts', function(Blueprint $table) {
            $table->renameColumn('mtb', 'mtb_code');
            $table->renameColumn('rif', 'rif_code');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('consult_laboratory_gene_xperts', function(Blueprint $table) {
            $table->renameColumn('mtb_code', 'mtb');
            $table->renameColumn('rif_code', 'rif');
        });
        Schema::enableForeignKeyConstraints();
    }
};
