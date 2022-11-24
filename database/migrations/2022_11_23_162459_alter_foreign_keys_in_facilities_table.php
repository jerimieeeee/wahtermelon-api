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
        Schema::disableForeignKeyConstraints();
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            $table->dropForeign(['province_id']);
            $table->dropForeign(['municipality_id']);
            $table->dropForeign(['barangay_id']);

            $table->dropColumn('region_id');
            $table->dropColumn('province_id');
            $table->dropColumn('municipality_id');
            $table->dropColumn('barangay_id');

            $table->string('region_code')->after('ownership_sub_classification');
            $table->string('province_code')->after('region_code');
            $table->string('municipality_code')->after('province_code');
            $table->string('barangay_code')->nullable()->after('municipality_code');

            $table->foreign('region_code')->references('code')->on('regions');
            $table->foreign('province_code')->references('code')->on('provinces');
            $table->foreign('municipality_code')->references('code')->on('municipalities');
            $table->foreign('barangay_code')->references('code')->on('barangays');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('facilities', function (Blueprint $table) {
            $table->dropForeign(['region_code']);
            $table->dropForeign(['province_code']);
            $table->dropForeign(['municipality_code']);
            $table->dropForeign(['barangay_code']);

            $table->dropColumn('region_code');
            $table->dropColumn('province_code');
            $table->dropColumn('municipality_code');
            $table->dropColumn('barangay_code');

            $table->foreignId('region_id')->after('ownership_sub_classification')->constrained();
            $table->foreignId('province_id')->after('region_id')->constrained();
            $table->foreignId('municipality_id')->after('province_id')->constrained();
            $table->foreignId('barangay_id')->nullable()->after('municipality_id')->constrained();
        });
        Schema::enableForeignKeyConstraints();
    }
};
