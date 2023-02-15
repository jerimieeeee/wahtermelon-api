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
        Schema::table('medicine_prescriptions', function (Blueprint $table) {
            $table->unsignedInteger('instruction_quantity')->nullable()->after('added_medicine');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medicine_prescriptions', function (Blueprint $table) {
            $table->dropColumn('instruction_quantity');
        });
    }
};
