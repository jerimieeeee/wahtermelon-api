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
        Schema::table('consult_notes', function(Blueprint $table) {
            $table->renameColumn('idx_remark', 'idx_remarks');
            $table->renameColumn('fdx_remark', 'fdx_remarks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consult_notes', function(Blueprint $table) {
            $table->renameColumn('idx_remarks', 'idx_remark');
            $table->renameColumn('fdx_remarks', 'fdx_remark');
        });
    }
};
