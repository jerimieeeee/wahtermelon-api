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
        Schema::table('users', function (Blueprint $table) {
            $table->string('facility_code')->nullable()->index()->after('id');
            $table->char('designation_code',20)->nullable()->index()->after('accreditation_number');
            $table->char('employer_code',10)->nullable()->index()->after('designation_code');
            $table->boolean('is_active')->default(0)->change();

            $table->foreign('facility_code')->references('code')->on('facilities')->constrained();
            $table->foreign('designation_code')->references('code')->on('lib_designations')->constrained();
            $table->foreign('employer_code')->references('code')->on('lib_employers')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['facility_code']);
            $table->dropForeign(['designation_code']);
            $table->dropForeign(['employer_code']);

            $table->dropColumn('facility_code');
            $table->dropColumn('designation_code');
            $table->dropColumn('employer_code');

            $table->boolean('is_active')->default(1)->change();

        });
        Schema::enableForeignKeyConstraints();
    }
};
