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
        Schema::create('lib_tb_treatment_outcomes', function (Blueprint $table) {
            $table->char('code');
            $table->string('desc', 50);
            $table->unsignedInteger('sequence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_tb_treatment_outcomes');
    }
};
