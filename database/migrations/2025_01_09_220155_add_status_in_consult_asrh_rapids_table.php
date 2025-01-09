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
            $table->enum('status', ['done', 'refused'])->nullable(1)->after('notes');
            $table->dropColumn('end_date');
            $table->foreignUuid('refer_to_user_id')->index()->nullable()->after('user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consult_asrh_rapids', function (Blueprint $table) {
            $table->dropConstrainedForeignId('refer_to_user_id');
            $table->dropColumn('status');
            $table->date('end_date')->index()->nullable(1)->after('assessment_date');
        });
    }
};
