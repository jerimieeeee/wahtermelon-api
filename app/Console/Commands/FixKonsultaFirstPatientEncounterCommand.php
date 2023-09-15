<?php

namespace App\Console\Commands;

use App\Classes\PhilHealthEClaimsEncryptor;
use App\Models\V1\Konsulta\KonsultaTransmittal;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FixKonsultaFirstPatientEncounterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:fpe';

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
        $credentials = PhilhealthCredential::query()->whereProgramCode('kp')->get()->pluck('facility_code')->toArray();
        $facility = $this->choice(
            'Select facility to be fix:',
            $credentials
        );
        $konsulta = KonsultaTransmittal::query()->whereDoesntHave('patientPhilhealth')->whereFacilityCode($facility)->whereTranche(1)->get();

        foreach ($konsulta as $data) {
            $fileStorage = Storage::disk('spaces');

            $fileContent = $fileStorage->get($data->xml_url);
            $decryptor = new PhilHealthEClaimsEncryptor();
            $credential = PhilhealthCredential::query()->select('cipher_key')->whereProgramCode('kp')->whereFacilityCode($facility)->first();
            $xml = $decryptor->decryptPayloadDataToXml($fileContent, $credential->cipher_key);
            dump(XML2JSON($xml));

        }
    }
}
