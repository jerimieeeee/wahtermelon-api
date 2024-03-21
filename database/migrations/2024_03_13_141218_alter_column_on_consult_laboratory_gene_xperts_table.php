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
        Schema::table('consult_laboratory_gene_xperts', function (Blueprint $table) {
            $table->unsignedBigInteger('consult_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consult_laboratory_gene_xperts', function (Blueprint $table) {
            $table->unsignedBigInteger('consult_id')->nullable(false)->change();
        });
    }
};
