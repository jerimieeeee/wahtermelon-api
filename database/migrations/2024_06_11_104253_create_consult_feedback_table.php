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
        Schema::create('consult_feedback', function (Blueprint $table) {
            $table->ulid('id')->index()->primary();
            $table->foreignId('consult_id')->nullable()->index()->constrained();

            $table->tinyInteger('overall_score')->unsigned();
            $table->tinyInteger('cleanliness_score')->unsigned();
            $table->tinyInteger('behavior_score')->unsigned();
            $table->tinyInteger('time_score')->unsigned();
            $table->tinyInteger('quality_score')->unsigned();
            $table->tinyInteger('completeness_score')->unsigned();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consult_feedback');
    }
};
