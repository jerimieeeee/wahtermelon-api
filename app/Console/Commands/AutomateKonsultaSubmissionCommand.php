<?php

namespace App\Console\Commands;

use App\Jobs\ProcessKonsultaSubmissionJob;
use App\Models\V1\Patient\PatientPhilhealth;
use App\Services\PhilHealth\KonsultaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;

class AutomateKonsultaSubmissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'konsulta:validate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automate Konsulta submission using batch jobs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //$batch = Bus::batch([])->dispatch();

        /* $batch = Bus::batch([])->dispatch();

        PatientPhilhealth::query()
            ->whereEffectivityYear('2024')
            ->withWhereHas('konsultaRegistration', fn ($query) => $query->whereEffectivityYear('2024'))
            ->withWhereHas('patient.patientHistory')
            ->withWhereHas('patient.consult', function ($q) {
            $q->whereNull('transmittal_number')->where('is_konsulta', 1)
                ->where('facility_code', 'DOH000000000048882')
                ->whereYear('consult_date', '2024')
                ->wherePtGroup('cn')
                ->whereHas('finalDiagnosis');
            })
            ->whereIn('membership_type_id', ['MM', 'DD'])
            ->chunk(1000, function ($data) use ($batch) {
                $batch->add(new ProcessKonsultaSubmissionJob($data->toArray()));
            });

        $this->info('Konsulta submission jobs dispatched.'); */

        /* $data = PatientPhilhealth::query()
            ->whereEffectivityYear('2024')
            ->withWhereHas('konsultaRegistration', fn ($query) => $query->whereEffectivityYear('2024'))
            ->withWhereHas('patient.patientHistory')
            ->withWhereHas('patient.consult', function ($q) {
            $q->whereNull('transmittal_number')->where('is_konsulta', 1)
                ->where('facility_code', 'DOH000000000048882')
                ->whereYear('consult_date', '2024')
                ->wherePtGroup('cn')
                ->whereHas('finalDiagnosis');
            })
            ->whereIn('membership_type_id', ['MM', 'DD'])
            //->take(100)
            ->get()
            ->toArray();
        //dd(count($data));
        // Chunk the data and create jobs
        $jobs = [];
        foreach (array_chunk($data, 50) as $chunk) {
            $jobs[] = new ProcessKonsultaSubmissionJob($chunk);
        }

        // Dispatch the batch
        $batch = Bus::batch($jobs)->dispatch();

        $this->info('Konsulta submission jobs dispatched.'); */

        $take = $this->ask('Enter the number of records to process (default: 100)', 100);
        $tranche = $this->ask('Enter the tranche (default: 2)', 2);
        $save = $this->ask('Enter the save flag status (default: 1)', 1);
        $year = $this->ask('Enter the target year for processing (default: 2024)', 2024);

        $this->info("Processing Konsulta submissions with batch size: {$take}");
        $this->info("Parameters: tranche={$tranche}, save={$save}, year={$year}");

        // Fetch the data
        $data = PatientPhilhealth::query()
            ->whereEffectivityYear($year)
            ->withWhereHas('konsultaRegistration', fn($query) => $query->whereEffectivityYear($year)->whereFacility_code('DOH000000000048882'))
            ->withWhereHas('patient.patientHistory')
            ->when($tranche == 1, fn ($query) => $query->whereNull('transmittal_number'))
            ->when($tranche == 2, function ($query) use($year){
                $query->withWhereHas('patient.consult', function ($q) use ($year) {
                    $q->whereNull('transmittal_number')
                        ->where('is_konsulta', 1)
                        ->where('facility_code', 'DOH000000000048882')
                        ->whereYear('consult_date', $year)
                        ->wherePtGroup('cn')
                        ->whereHas('finalDiagnosis');
                });
            })
            ->whereIn('membership_type_id', ['MM', 'DD'])
            ->take($take)
            ->get()
            ->toArray();

        $this->info("Retrieved " . count($data) . " records for processing.");

        if (empty($data)) {
            $this->warn('No records found to process.');
            return;
        }


        // Define minimum and maximum chunk sizes
        $minChunkSize = 1; // Minimum number of records per chunk
        $maxChunkSize = 1000; // Maximum number of records per chunk

        // Calculate dynamic chunk size
        $totalRecords = $take;
        $chunkSize = (int) max($minChunkSize, min($maxChunkSize, ceil($totalRecords / 10))); // Adjust divisor as needed

        // Create jobs
        $jobs = [];
        foreach (array_chunk($data, $chunkSize) as $chunk) {
            $jobs[] = new ProcessKonsultaSubmissionJob($chunk, $tranche, $save, $year);
        }

        // Dispatch the batch
        $batch = Bus::batch($jobs)->dispatch();

        $this->info('Konsulta submission jobs dispatched successfully.');

    }
}
