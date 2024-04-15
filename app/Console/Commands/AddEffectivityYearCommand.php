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
    public function handle()
    {
        $konsultaFPE = KonsultaTransmittal::query()->select('id',  'transmittal_number', 'effectivity_year')->whereHas('philhealth')->whereTranche(1)->get();
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
        }
    }
}
