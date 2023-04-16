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
        Schema::create('lib_laboratory_request_statuses', function (Blueprint $table) {
            $table->char('code', 10)->index()->primary();
            $table->string('desc')->index();
            $table->unsignedInteger('sequence');
        });

        Artisan::call('db:seed', [
            '--class' => 'LibLaboratoryRequestStatusSeeder',
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
        Schema::dropIfExists('lib_laboratory_request_statuses');
    }
};
