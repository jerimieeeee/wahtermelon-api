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

        $data = PatientPhilhealth::query()
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
            ->take(1000)
            ->get()
            ->toArray();

        // Chunk the data and create jobs
        $jobs = [];
        foreach (array_chunk($data, 500) as $chunk) {
            $jobs[] = new ProcessKonsultaSubmissionJob($chunk);
        }

        // Dispatch the batch
        $batch = Bus::batch($jobs)->dispatch();

        $this->info('Konsulta submission jobs dispatched.');

    }
}
