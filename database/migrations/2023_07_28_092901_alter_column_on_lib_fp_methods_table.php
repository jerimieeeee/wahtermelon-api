<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lib_fp_methods', function (Blueprint $table) {
            $table->renameColumn('id', 'code');
            $table->renameColumn('method_desc', 'desc');
            $table->renameColumn('method_gender', 'gender');
            $table->renameColumn('report_order', 'sequence');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lib_fp_methods', function (Blueprint $table) {
            $table->renameColumn('code', 'id');
            $table->renameColumn('desc', 'method_desc');
            $table->renameColumn('gender', 'method_gender');
            $table->renameColumn('sequence', 'report_order');
        });
    }
};
