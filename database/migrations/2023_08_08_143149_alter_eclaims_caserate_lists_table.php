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
        Schema::table('eclaims_caserate_lists', function (Blueprint $table) {
            $table->boolean('enough_benefit_flag')->default(false)->after('icd10_code');

            $table->decimal('hci_pTotalActualCharges', 7, 2)->after('enough_benefit_flag')->nullable();
            $table->decimal('hci_pDiscount', 7, 2)->after('hci_pTotalActualCharges')->nullable();
            $table->decimal('hci_pPhilhealthBenefit', 7, 2)->after('hci_pDiscount')->nullable();
            $table->decimal('hci_pTotalAmount', 7, 2)->after('hci_pPhilhealthBenefit')->nullable();

            $table->decimal('prof_pTotalActualCharges', 7, 2)->after('hci_pTotalAmount')->nullable();
            $table->decimal('prof_pDiscount', 7, 2)->after('prof_pTotalActualCharges')->nullable();
            $table->decimal('prof_pPhilhealthBenefit', 7, 2)->after('prof_pDiscount')->nullable();
            $table->decimal('prof_pTotalAmount', 7, 2)->after('prof_pPhilhealthBenefit')->nullable();

            $table->boolean('meds_flag')->default(false)->after('prof_pTotalAmount');
            $table->decimal('meds_pDMSTotalAmount', 7, 2)->after('meds_flag')->nullable();
            $table->boolean('meds_pExaminations_flag')->default(false)->after('meds_pDMSTotalAmount');
            $table->string('meds_pExamTotalAmount', 7, 2)->after('meds_pExaminations_flag')->nullable();

            $table->boolean('hmo_flag')->default(false)->after('meds_pExamTotalAmount');
            $table->boolean('others_flag')->default(false)->after('hmo_flag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eclaims_caserate_lists', function (Blueprint $table) {
            $table->dropColumn('enough_benefit_flag');
            $table->dropColumn('hmo_flag');
            $table->dropColumn('others_flag');
            $table->dropColumn('hci_pTotalActualCharges');
            $table->dropColumn('hci_pDiscount');
            $table->dropColumn('hci_pPhilhealthBenefit');
            $table->dropColumn('hci_pTotalAmount');
            $table->dropColumn('prof_pTotalActualCharges');
            $table->dropColumn('prof_pDiscount');
            $table->dropColumn('prof_pPhilhealthBenefit');
            $table->dropColumn('prof_pTotalAmount');
            $table->dropColumn('meds_flag');
            $table->dropColumn('meds_pDMSTotalAmount');
            $table->dropColumn('meds_pExaminations_flag');
            $table->dropColumn('meds_pExamTotalAmount');
        });
    }
};
