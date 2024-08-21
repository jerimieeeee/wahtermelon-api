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
        Schema::table('eclaims_uploads', function (Blueprint $table) {
            $table->json('return_reason')->after('denied_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('eclaims_uploads', function (Blueprint $table) {
            $table->dropColumn('return_reason');
        });
        Schema::enableForeignKeyConstraints();
    }
};
