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
                $table->unsignedBigInteger('status_id')->nullable()->index()->constrained()->after('vaccine_date');

                $table->foreign('status_id')->references('status_id')->on('lib_vaccine_statuses');
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
        //
    }
};
