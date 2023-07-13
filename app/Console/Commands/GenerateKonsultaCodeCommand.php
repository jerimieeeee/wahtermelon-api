<?php

namespace App\Console\Commands;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientPhilhealth;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Console\Command;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Support\Facades\DB;

class GenerateKonsultaCodeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'konsulta:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Konsulta Case Number and Transanction Number';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = new Patient;
        $tableName = $data->getTable();
        $patients = $data->whereNull('case_number')->withWhereHas('philhealthKonsulta')->get();
        $patients->map(function($patient) use($tableName){
            $credential = $patient->philhealthKonsulta->pluck('accreditation_number')->first();
            $prefix = 'T'.$credential.$patient->created_at->format('Ym');
            $caseNumber = IdGenerator::generate(['table' => $tableName, 'field' => 'case_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
            $patient->update(['case_number' => $caseNumber]);
        });

        $consults = new Consult;
        $consultTableName = $consults->getTable();
        $consultData = $consults->whereNull('transaction_number')->wherePtGroup('cn')->whereHas('consultNotes.finaldx')->withWhereHas('patient.philhealthKonsulta')->get();
        $consultData->map(function($consult) use($consultTableName){
            $credential = $consult->patient->philhealthKonsulta->pluck('accreditation_number')->first();
            $prefix = $credential.$consult->created_at->format('Ym');
            $transactionNumber = IdGenerator::generate(['table' => $consultTableName, 'field' => 'transaction_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
            $consult->update(['transaction_number' => $transactionNumber]);
        });

        $philhealth = new PatientPhilhealth;
        $philhealthTableName = $philhealth->getTable();
//        $philhealth->whereIn('id', function ($query) use($philhealthTableName){
//            $query->select('id')
//                ->from(function ($subquery) use ($philhealthTableName) {
//                    $subquery->selectRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(id ORDER BY created_at DESC), ',', 1), ',', -1) AS id")
//                        ->from($philhealthTableName)
//                        ->whereNull('transmittal_number')
//                        ->groupBy('patient_id', 'effectivity_year')
//                        ->havingRaw('count(patient_id) > 1');
//                });
//        })->delete();
        //echo $philhealth->get();
        do {
            // Retrieve the duplicate records
            $duplicateRecords = $philhealth->whereIn('id', function ($query) use ($philhealthTableName) {
                $query->select('id')
                    ->from(function ($subquery) use ($philhealthTableName) {
                        $subquery->selectRaw("SUBSTRING_INDEX(SUBSTRING_INDEX(GROUP_CONCAT(id ORDER BY created_at DESC), ',', 1), ',', -1) AS id")
                            ->from($philhealthTableName)
                            ->whereNull('transmittal_number')
                            ->groupBy('patient_id', 'effectivity_year')
                            ->havingRaw('count(patient_id) > 1');
                    });
            })->get();

            if ($duplicateRecords->count() > 0) {
                // Delete the duplicate records
                $philhealth->whereIn('id', $duplicateRecords->pluck('id'))->delete();
            }
        } while ($duplicateRecords->count() > 0);
        $philhealthData = $philhealth->whereNull('transaction_number')->withWhereHas('patient.philhealthKonsulta')->get();
        $philhealthData->map(function($philhealth) use($philhealthTableName){
            $credential = $philhealth->patient->philhealthKonsulta->pluck('accreditation_number')->first();
            $prefix = $credential.$philhealth->created_at->format('Ym');
            $transactionNumber = IdGenerator::generate(['table' => $philhealthTableName, 'field' => 'transaction_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
            $philhealth->update(['transaction_number' => $transactionNumber]);
        });
    }
}
