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
        Schema::table('consult_notes_initial_dxes', function (Blueprint $table) {
            $table->dropColumn('idx_remark');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_notes_initial_dxes', function (Blueprint $table) {
            $table->string('idx_remark')->nullable();
        });
    }
};
