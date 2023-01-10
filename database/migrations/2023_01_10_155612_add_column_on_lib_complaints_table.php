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
        Schema::table('lib_complaints', function (Blueprint $table) {
            $table->boolean('complaint_active')->nullable()->change();
            $table->char('konsulta_complaint_id', 4)->nullable()->after('complaint_active');
            $table->boolean('konsulta_library_status')->nullable()->after('konsulta_complaint_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lib_complaints', function (Blueprint $table) {
            $table->boolean('complaint_active')->nullable(false)->change();
            $table->dropColumn('konsulta_complaint_id');
            $table->dropColumn('konsulta_library_status');
        });
    }
};
