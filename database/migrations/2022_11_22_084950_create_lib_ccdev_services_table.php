<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('lib_ccdev_services', function (Blueprint $table) {
            $table->string('service_id');
            $table->string('service_name');
            $table->string('order_seq');
            $table->string('service_cat');

            $table->primary('service_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lib_ccdev_services');
    }
};
