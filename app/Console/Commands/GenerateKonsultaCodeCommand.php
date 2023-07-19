<?php

namespace App\Console\Commands;

use App\Models\V1\Consultation\Consult;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientPhilhealth;
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
        //Update Case Number of Patient Table
        $data = new Patient;
        $tableName = $data->getTable();
        $patients = $data->whereNull('case_number')->withWhereHas('philhealthKonsulta')->get();

        $patientBar = $this->output->createProgressBar(count($patients));
        $patientBar->setFormat('Processing Patient Table: %current%/%max% [%bar%] %percent:3s%%');
        $patientBar->start();
        $patients->map(function ($patient) use ($tableName, $patientBar) {
            $credential = $patient->philhealthKonsulta->pluck('accreditation_number')->first();
            $prefix = 'T'.$credential.$patient->created_at->format('Ym');
            $caseNumber = IdGenerator::generate(['table' => $tableName, 'field' => 'case_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
            $patient->update(['case_number' => $caseNumber]);
            $patientBar->advance();
            $patientBar->setMessage('Processing...');
        });
        $patientBar->finish();
        $this->newLine();
        $this->components->twoColumnDetail('Patient case number generation', 'Done');
        $this->newLine();

        //Update Transaction Number of Consult Table
        $consults = new Consult;
        $consultTableName = $consults->getTable();
        $consultData = $consults->whereNull('transaction_number')->wherePtGroup('cn')->whereHas('consultNotes.finaldx')->withWhereHas('patient.philhealthKonsulta')->get();

        $consultBar = $this->output->createProgressBar(count($consultData));
        $consultBar->setFormat('Processing Consult Table: %current%/%max% [%bar%] %percent:3s%%');
        $consultBar->start();
        $consultData->map(function ($consult) use ($consultTableName, $consultBar) {
            $credential = $consult->patient->philhealthKonsulta->pluck('accreditation_number')->first();
            $prefix = $credential.$consult->created_at->format('Ym');
            $transactionNumber = IdGenerator::generate(['table' => $consultTableName, 'field' => 'transaction_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
            $consult->update(['transaction_number' => $transactionNumber]);
            $consultBar->advance();
        });
        $consultBar->finish();
        $this->newLine();
        $this->components->twoColumnDetail('Consult transaction number generation', 'Done');
        $this->newLine();

        //Update Transaction Number of Patient Philhealth Table
        $philhealth = new PatientPhilhealth;
        $philhealthTableName = $philhealth->getTable();

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

        $philhealthBar = $this->output->createProgressBar(count($philhealthData));
        $philhealthBar->setFormat('Processing Philhealth Table: %current%/%max% [%bar%] %percent:3s%%');
        $philhealthBar->start();
        $philhealthData->map(function ($philhealth) use ($philhealthTableName, $philhealthBar) {
            $credential = $philhealth->patient->philhealthKonsulta->pluck('accreditation_number')->first();
            $prefix = $credential.$philhealth->created_at->format('Ym');
            $transactionNumber = IdGenerator::generate(['table' => $philhealthTableName, 'field' => 'transaction_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
            $philhealth->update(['transaction_number' => $transactionNumber]);
            $philhealthBar->advance();
        });
        $philhealthBar->finish();
        $this->newLine();
        $this->components->twoColumnDetail('Patient philhealth transaction number generation', 'Done');
        $this->newLine();
    }
}
