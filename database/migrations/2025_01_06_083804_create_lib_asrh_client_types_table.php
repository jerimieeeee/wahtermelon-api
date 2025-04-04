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
        Schema::create('lib_asrh_client_types', function (Blueprint $table) {
            $table->char('code', 10)->primary()->index();
            $table->string('desc');
            $table->unsignedInteger('sequence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_asrh_client_types');
    }
};
