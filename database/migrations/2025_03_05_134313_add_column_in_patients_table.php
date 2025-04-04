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
        Schema::table('patients', function (Blueprint $table) {
            $table->char('lib_gender_identity_code', 10)->nullable(true)->index()->after('gender');
            $table->foreign('lib_gender_identity_code')->references('code')->on('lib_gender_identities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeign(['lib_gender_identity_code']);
            $table->dropColumn('lib_gender_identity_code');
        });
    }
};
