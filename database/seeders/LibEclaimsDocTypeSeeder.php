<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibEclaimsDocType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibEclaimsDocTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibEclaimsDocType::upsert([
            ['code' => 'ANR', 'desc' => 'Anesthesia Record', 'sequence' => 1],
            ['code' => 'CAB', 'desc' => 'Clinical Abstract', 'sequence' => 2],
            ['code' => 'CAE', 'desc' => 'Certification of Approval/Agreement from the Employer', 'sequence' => 3],
            ['code' => 'CF1', 'desc' => 'Claim Form 1', 'sequence' => 4],
            ['code' => 'CF2', 'desc' => 'Claim Form 2', 'sequence' => 5],
            ['code' => 'CF3', 'desc' => 'Claim Form 3', 'sequence' => 6],
            ['code' => 'COE', 'desc' => 'Certificate of Eligibility', 'sequence' => 7],
            ['code' => 'CSF', 'desc' => 'Claim Signature Form', 'sequence' => 8],
            ['code' => 'CTR', 'desc' => 'Confirmatory Test Results by SACCL or RITM', 'sequence' => 9],
            ['code' => 'DTR', 'desc' => 'Diagnostic Test Result', 'sequence' => 10],
            ['code' => 'HDR', 'desc' => 'Hemodialysis Record', 'sequence' => 11],
            ['code' => 'MBC', 'desc' => 'Member\'s Birth Certificate', 'sequence' => 12],
            ['code' => 'MDR', 'desc' => 'Proof of MDR with Payment Details', 'sequence' => 13],
            ['code' => 'MEF', 'desc' => 'Member Empowerment Form', 'sequence' => 14],
            ['code' => 'MMC', 'desc' => 'Member\'s Marriage Contract', 'sequence' => 15],
            ['code' => 'MRF', 'desc' => 'PhilHealth Member Registration Form', 'sequence' => 16],
            ['code' => 'MSR', 'desc' => 'Malarial Smear Results', 'sequence' => 17],
            ['code' => 'MWV', 'desc' => 'Waiver for Consent for Release of Confidential Patient Health Information', 'sequence' => 18],
            ['code' => 'NTP', 'desc' => 'NTP Registry Card', 'sequence' => 19],
            ['code' => 'OPR', 'desc' => 'Operative Record', 'sequence' => 20],
            ['code' => 'ORS', 'desc' => 'Official Receipts', 'sequence' => 21],
            ['code' => 'OTH', 'desc' => 'Other documents', 'sequence' => 22],
            ['code' => 'PAC', 'desc' => 'Pre-Authorization Clearance', 'sequence' => 23],
            ['code' => 'PBC', 'desc' => 'Patient\'s Birth Certificate', 'sequence' => 24],
            ['code' => 'PIC', 'desc' => 'Valid Philhealth Indigent ID', 'sequence' => 25],
            ['code' => 'POR', 'desc' => 'PhilHealth Official Receipts', 'sequence' => 26],
            ['code' => 'SOA', 'desc' => 'Statement of Account', 'sequence' => 27],
            ['code' => 'STR', 'desc' => 'HIV Screening Test Result', 'sequence' => 28],
            ['code' => 'TCC', 'desc' => 'TB-Diagnostic Committee Certification (-) Sputum', 'sequence' => 29],
            ['code' => 'TYP', 'desc' => 'Three Years Payment of (2400 x 3 years of proof of payment)', 'sequence' => 30],
        ], ['code']);
    }
}
