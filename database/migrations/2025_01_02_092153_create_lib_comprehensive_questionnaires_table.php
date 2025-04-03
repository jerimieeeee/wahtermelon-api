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
        Schema::create('lib_comprehensive_questionnaires', function (Blueprint $table) {
            $table->char('code', 10)->primary()->index();
            $table->char('lib_comprehensive_code')->index();
            $table->foreign('lib_comprehensive_code')->references('code')->on('lib_comprehensives')->onDelete('cascade');
            $table->string('question');
            $table->unsignedInteger('sequence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_comprehensive_questionnaires');
    }
};
