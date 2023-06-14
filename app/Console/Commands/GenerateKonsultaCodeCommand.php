<?php

namespace App\Console\Commands;

use App\Models\V1\Patient\Patient;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Console\Command;

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

        echo $tableName = $data->getTable();
        $patients = $data->whereNull('case_number')->withWhereHas('philhealthKonsulta')->get();
        $patients->map(function($patient) use($tableName){
//            echo $credential = PhilhealthCredential::query()
//                ->select('accreditation_number')
//                ->where('facility_code', $patient->facility_code)
//                ->whereProgramCode('kp')
//                ->first();
            $credential = $patient->philhealthKonsulta->pluck('accreditation_number')->first();
            //echo $credential->accreditation_number;
            $prefix = 'T'.$credential.$patient->created_at->format('Ym');
            $caseNumber = IdGenerator::generate(['table' => $tableName, 'field' => 'case_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
            $patient->update(['case_number' => $caseNumber]);
        });

        //$prefix = 'T'.auth()->user()->konsultaCredential->accreditation_number.date('Ym');
        //$caseNumber = IdGenerator::generate(['table' => $tableName, 'field' => 'case_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
//        $model->case_number = $caseNumber;
//        $this->table(
//            ['Last Name', 'First Name', 'Middle Name'],
//            $data
//        );
//        echo $data->count();
    }
}
