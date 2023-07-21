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
            $table->string('pTransmissionControlNumber', 20)->change();
            $table->string('pReceiptTicketNumber', 20)->change();
            $table->string('pClaimSeriesLhio', 20)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eclaims_uploads', function (Blueprint $table) {
            $table->string('pTransmissionControlNumber', 18)->change();
            $table->string('pReceiptTicketNumber', 18)->change();
            $table->string('pClaimSeriesLhio', 18)->change();
        });
    }
};
