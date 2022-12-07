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
        Schema::table('lib_ccdev_services', function (Blueprint $table) {
            $table->renameColumn('service_cat', 'essential');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lib_ccdev_services', function (Blueprint $table) {
            $table->renameColumn('essential', 'service_cat');
        });
    }
};
