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
        Schema::table('consult_mc_prenatals', function (Blueprint $table) {
            $table->text('remarks')->nullable()->after('private');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_mc_prenatals', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });
    }
};
