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
        Schema::table('consult_asrh_rapids', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->boolean('refused_flag')->default(false)->after('notes');
            $table->boolean('done_flag')->default(false)->after('refused_flag');
            $table->date('done_date')->nullable()->after('done_flag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consult_asrh_rapids', function (Blueprint $table) {
            $table->enum('status', ['done', 'refused'])->nullable(1)->after('notes');
            $table->dropColumn('refused_flag');
            $table->dropColumn('done_flag');
            $table->dropColumn('done_date');
        });
    }
};
