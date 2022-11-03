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
        if (Schema::hasColumn('patient_vaccines', 'pt_group')){

            Schema::table('patient_vaccines', function (Blueprint $table) {
                $table->dropColumn('pt_group');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patient_vaccines', function($table) {
            $table->char('pt_group', 4);
        });

    }
};
