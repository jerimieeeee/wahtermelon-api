<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lib_laboratory_recommendations', function (Blueprint $table) {
            $table->char('code', 10)->index()->primary();
            $table->string('desc')->index();
            $table->unsignedInteger('sequence');
        });

        Artisan::call('db:seed', [
            '--class' => 'LibLaboratoryRecommendationSeeder',
            '--force' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_laboratory_recommendations');
    }
};
