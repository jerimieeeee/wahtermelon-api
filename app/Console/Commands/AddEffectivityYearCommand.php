<?php

namespace App\Console\Commands;

use App\Models\V1\Konsulta\KonsultaTransmittal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddEffectivityYearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'konsulta:add-effectivity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    //public function handle()
    //{
        /*$konsultaFPE = KonsultaTransmittal::query()->select('id',  'transmittal_number', 'effectivity_year')->whereHas('philhealth')->whereTranche(1)->get();
        foreach ($konsultaFPE as $transmittal) {
            $philhealthRecord = $transmittal->philhealth()->select('id', 'transmittal_number', 'effectivity_year')->first(); // Fetch the first related PatientPhilhealth record
            //dd($philhealthRecord);
            if ($philhealthRecord) {
                $effectivityYear = $philhealthRecord->effectivity_year;
                //dd($philhealthRecord);
                // Update the effectivity_year column of the current KonsultaTransmittal record
                $transmittal->update(['effectivity_year' => $effectivityYear]);
            }
        }

        $konsultaSOAP = KonsultaTransmittal::query()->select('id', 'transmittal_number', 'effectivity_year')->whereHas('consult')->whereTranche(2)->get();

        foreach ($konsultaSOAP as $transmittal) {
            $consultRecord = $transmittal->consult()->select('id', 'transmittal_number', DB::raw('YEAR(consult_date) AS effectivity_year'))->first(); // Fetch the first related PatientPhilhealth record
            if ($consultRecord) {
                $effectivityYear = $consultRecord->effectivity_year;

                // Update the effectivity_year column of the current KonsultaTransmittal record
                $transmittal->update(['effectivity_year' => $effectivityYear]);
            }
        }*/
        /*$this->info('Updating effectivity year for KonsultaTransmittal records...');

        // Query and update KonsultaTransmittal records for FPE transmittals
        $konsultaFPE = KonsultaTransmittal::query()
            ->select('id', 'transmittal_number', 'effectivity_year')
            ->whereHas('philhealth')
            ->whereTranche(1)
            ->get();

        $progressBar = $this->output->createProgressBar(count($konsultaFPE));
        $progressBar->setFormat('Processing Konsulta FPE: %current%/%max% [%bar%] %percent:3s%% Elapsed: %elapsed:6s% Remaining: %remaining:6s% Estimated: %estimated:-6s%');
        $progressBar->start();
        $startTime = time();

        foreach ($konsultaFPE as $transmittal) {
            $philhealthRecord = $transmittal->philhealth()->select('id', 'transmittal_number', 'effectivity_year')->first();

            if ($philhealthRecord) {
                $effectivityYear = $philhealthRecord->effectivity_year;
                $transmittal->update(['effectivity_year' => $effectivityYear]);
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $endTime = time();
        $elapsedTime = $endTime - $startTime;
        $this->newLine();
        $this->line('Elapsed Time: ' . gmdate('H:i:s', $elapsedTime));
        $this->info("FPE transmittal records updated successfully.");

        // Query and update KonsultaTransmittal records for SOAP transmittals
        $konsultaSOAP = KonsultaTransmittal::query()
            ->select('id', 'transmittal_number', 'effectivity_year')
            ->whereHas('consult')
            ->whereTranche(2)
            ->get();

        $progressBar = $this->output->createProgressBar(count($konsultaSOAP));
        $progressBar->setFormat('Processing Konsulta SOAP: %current%/%max% [%bar%] %percent:3s%% Elapsed: %elapsed:6s% Remaining: %remaining:6s% Estimated: %estimated:-6s%');
        $progressBar->start();
        $startTime = time();

        foreach ($konsultaSOAP as $transmittal) {
            $consultRecord = $transmittal->consult()->select('id', 'transmittal_number', DB::raw('YEAR(consult_date) AS effectivity_year'))->first();

            if ($consultRecord) {
                $effectivityYear = $consultRecord->effectivity_year;
                $transmittal->update(['effectivity_year' => $effectivityYear]);
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $endTime = time();
        $elapsedTime = $endTime - $startTime;
        $this->newLine();
        $this->line('Elapsed Time: ' . gmdate('H:i:s', $elapsedTime));
        $this->info("SOAP transmittal records updated successfully.");*/
    //}

    public function handle()
    {
        $this->updateTransmittalRecords(1, 'FPE');
        $this->updateTransmittalRecords(2, 'SOAP');
    }

    private function updateTransmittalRecords($tranche, $type)
    {
        $this->info("Updating effectivity year for KonsultaTransmittal records ({$type})...");

        $transmittals = KonsultaTransmittal::query()
            ->select('id', 'transmittal_number', 'effectivity_year')
            ->whereHas($type == 'FPE' ? 'philhealth' : 'consult')
            ->whereTranche($tranche)
            ->get();

        $progressBar = $this->output->createProgressBar(count($transmittals));
        $progressBar->setFormat("Processing Konsulta {$type}: %current%/%max% [%bar%] %percent:3s%% Elapsed: %elapsed:6s% Remaining: %remaining:6s% Estimated: %estimated:-6s%");
        $progressBar->start();
        $startTime = time();

        foreach ($transmittals as $transmittal) {
            $relatedRecord = $transmittal->{$type == 'FPE' ? 'philhealth' : 'consult'}()
                ->select('id', 'transmittal_number', $type == 'FPE' ? 'effectivity_year' : DB::raw('YEAR(consult_date) AS effectivity_year'))
                ->first();

            if ($relatedRecord) {
                $effectivityYear = $relatedRecord->effectivity_year;
                // Temporarily disable timestamps
                $transmittal->timestamps = false;
                $transmittal->update(['effectivity_year' => $effectivityYear]);
                $transmittal->timestamps = true;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $endTime = time();
        $elapsedTime = $endTime - $startTime;
        $this->newLine();
        $this->line('Elapsed Time: ' . gmdate('H:i:s', $elapsedTime));
        $this->info("{$type} transmittal records updated successfully.");
    }
}
