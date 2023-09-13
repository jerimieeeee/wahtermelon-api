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
        Schema::create('lib_medicines', function (Blueprint $table) {
            $table->string('hprodid',40);
            $table->string('drug_name',255);
            $table->string('gen_name',255);
            $table->string('form_desc',255);
            $table->string('stre_desc',255);

            $table->primary('hprodid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lib_medicines');
    }
};
