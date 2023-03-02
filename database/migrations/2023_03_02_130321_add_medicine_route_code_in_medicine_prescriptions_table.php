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
            $table->foreignId('medicine_route_code')->nullable()->index()->after('quantity_preparation')->constrained('lib_medicine_routes', 'code');
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
            $table->dropForeign(['medicine_route_code']);
            $table->dropColumn('medicine_route_code');
        });
    }
};
