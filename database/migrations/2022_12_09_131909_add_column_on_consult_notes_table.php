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
        Schema::table('consult_notes', function (Blueprint $table) {
            $table->string('idx_remark')->after('physical_exam')->nullable();
            $table->string('fdx_remark')->after('idx_remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_notes', function (Blueprint $table) {
            $table->dropColumn('idx_remark');
            $table->dropColumn('fdx_remark');
        });
    }
};
