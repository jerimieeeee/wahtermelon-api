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
        Schema::table('consult_mc_postparta', function (Blueprint $table) {
            $table->index('visit_type');
            $table->foreign('visit_type')->references('code')->on('lib_mc_visit_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_mc_postparta', function (Blueprint $table) {
            $table->dropForeign(['visit_type']);
            $table->dropIndex(['visit_type']);
        });
    }
};
