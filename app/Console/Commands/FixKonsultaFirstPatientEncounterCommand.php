<?php

namespace App\Console\Commands;

use App\Classes\PhilHealthEClaimsEncryptor;
use App\Models\V1\Konsulta\KonsultaTransmittal;
use App\Models\V1\Patient\PatientPhilhealth;
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
        $konsulta = KonsultaTransmittal::query()
            ->select('konsulta_transmittals.*')
            ->whereDoesntHave('patientPhilhealth')
            ->where('konsulta_transmittals.facility_code', $facility)
            ->whereTranche(1)
            ->whereXmlStatus('S')
            ->leftJoin('patient_philhealth', 'konsulta_transmittals.transmittal_number', '=', 'patient_philhealth.transmittal_number')
            ->whereNull('patient_philhealth.transmittal_number')
            ->get();

        $konsultaCount = count($konsulta);
        if($konsultaCount < 1){
            $this->components->info('Nothing to fix');
            return;
        }
        $konsultaBar = $this->output->createProgressBar($konsultaCount);
        $konsultaBar->setFormat('Fixing Konsulta Transmittal Number for First Patient Encounter: %current%/%max% [%bar%] %percent:3s%% Elapsed: %elapsed:6s% Remaining: %remaining:-6s% Estimated: %estimated:-6s%');
        $konsultaBar->start();
        $startTime = time();
        $decryptor = new PhilHealthEClaimsEncryptor();
        $credential = PhilhealthCredential::query()->select('cipher_key')->whereProgramCode('kp')->whereFacilityCode($facility)->first();
        foreach ($konsulta as $data) {
            $fileStorage = Storage::disk('spaces');

            $fileContent = $fileStorage->get($data->xml_url);

            $xml = $decryptor->decryptPayloadDataToXml($fileContent, $credential->cipher_key);
            //echo $facility;
            //echo $data->transmittal_number;
            //dd($xml);
//            echo $fileContent;
//            echo $data->transmittal_number;
            $arrayXML[] = XML2JSON($xml);
            //dump($arrayXML);
//                print_r($arrayXML);
//                dd($arrayXML);
            /*if ($arrayXML[0] instanceof \Illuminate\Http\JsonResponse) {
                $content = json_decode($arrayXML[0]->getContent(), true);
                echo $content['message'];
            } else {*/
                $arrayXML = collect($arrayXML);
                //dd($arrayXML);
                //dd($arrayXML);
                $arrayXML->map(function ($value) {
                    collect($value->ENLISTMENTS)->map(function ($enlistment) use ($value) {
                        if (is_array($enlistment)) {
                            collect($enlistment)->map(function ($enlistment) use ($value) {
                                $philhealth = PatientPhilhealth::query()->wherePhilhealthId($enlistment->pPatientPin)->whereEffectivityYear($enlistment->pEffYear)->update(['transmittal_number' => $value->pHciTransmittalNumber]);
                                //echo $philhealth;
                            });
                        } else {
                            $philhealth = PatientPhilhealth::query()->wherePhilhealthId($enlistment->pPatientPin)->whereEffectivityYear($enlistment->pEffYear)->update(['transmittal_number' => $value->pHciTransmittalNumber]);
                            //echo $philhealth;
                        }

                    });
                });
            //}
            $konsultaBar->advance();
        }

        $konsultaBar->finish();
        $endTime = time();
        $elapsedTime = $endTime - $startTime;

        $this->newLine();
        $this->components->twoColumnDetail('Konsulta Transmittal Fix', 'Done');
        $this->newLine();
        $this->line('Elapsed Time: ' . gmdate('H:i:s', $elapsedTime));
    }
}
