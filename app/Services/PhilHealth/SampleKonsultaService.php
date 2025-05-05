<?php

namespace App\Services\PhilHealth;

use App\Http\Resources\API\V1\Konsulta\ConsultationResource;
use App\Http\Resources\API\V1\Konsulta\DiagnosticExamResultResource;
use App\Http\Resources\API\V1\Konsulta\EnlistmentResource;
use App\Http\Resources\API\V1\Konsulta\MedicineResource;
use App\Http\Resources\API\V1\Konsulta\NoMedicineResource;
use App\Http\Resources\API\V1\Konsulta\ProfileResource;
use App\Http\Resources\API\V1\Konsulta\SoapDiagnosticExamResultResource;
use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Konsulta\KonsultaRegistrationList;
use App\Models\V1\Konsulta\KonsultaTransmittal;
use App\Models\V1\Laboratory\ConsultLaboratory;
use App\Models\V1\Medicine\MedicinePrescription;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientPhilhealth;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\ArrayToXml\ArrayToXml;

class SampleKonsultaService
{
    public function createXml($transmittalNumber = '', $patientId = [], $tranche = 1, $save = false, $revalidate = false, $effectivityYear = null)
    {
        return DB::transaction(function () use($transmittalNumber, $patientId, $save, $revalidate, $tranche, $effectivityYear){
            $credential = PhilhealthCredential::query()->whereFacilityCode('DOH000000000048882')->first();
            if (empty($transmittalNumber)) {
                $prefix = 'R'.$credential->accreditation_number.date('Ym');
                $transmittalNumber = IdGenerator::generate(['table' => 'konsulta_transmittals', 'field' => 'transmittal_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
            }

            $enlistments = $this->enlistments($transmittalNumber, $patientId, $save, $revalidate, $effectivityYear, $tranche);
            $profiling = $this->profilings($transmittalNumber, $patientId, $revalidate, $effectivityYear, $tranche);
            $soaps = $this->soaps($transmittalNumber, $patientId, $tranche, $save, $revalidate, $effectivityYear, $credential);
            $enlistmentCount = count($enlistments['ENLISTMENT'][0]);
            $profileCount = count($profiling[0]['PROFILE'][0]);
            $soapCount = count($soaps[0]['SOAP'][0]);

            $root = [
                'rootElementName' => 'PCB',
                '_attributes' => [
                    'pUsername' => '',
                    'pPassword' => '',
                    'pHciAccreNo' => $credential->accreditation_number ?? '',
                    'pPMCCNo' => $credential->pmcc_number ?? '',
                    'pEnlistTotalCnt' => $enlistmentCount,
                    'pProfileTotalCnt' => $profileCount,
                    'pSoapTotalCnt' => $soapCount,
                    'pCertificationId' => $credential->software_certification_id ?? '',
                    'pHciTransmittalNumber' => $transmittalNumber,
                ],
            ];

            $diagnosticArray = [];
            //$diagnosticArray = [$profiling[1]];
            if (isset($profiling[1]) && Arr::hasAny($profiling[1]['DIAGNOSTICEXAMRESULT'][0][0], [
                    'FBSS',
                    'RBSS',
                ])) {
                $diagnosticArray = $profiling[1];
            }
            if (isset($soaps[2]) && Arr::hasAny($soaps[2]['DIAGNOSTICEXAMRESULT'][0][0], [
                    'CBCS',
                    'URINALYSISS',
                    'CHESTXRAYS',
                    'SPUTUMS',
                    'LIPIDPROFILES',
                    'FBSS',
                    'RBSS',
                    'ECGS',
                    'FECALYSISS',
                    'PAPSMEARS',
                    'OGTTS',
                    'FOBTS',
                    'CREATININES',
                    'PPDTests',
                    'HbA1cs',
                ])) {
                foreach ($soaps[2]['DIAGNOSTICEXAMRESULT'][0] as $value) {
                    $diagnosticArray['DIAGNOSTICEXAMRESULT'][] = $value;
                }
            }

            $array = [];
            $array['ENLISTMENTS'] = [$enlistments];
            $array['PROFILING'] = [$profiling[0]];
            $array['SOAPS'] = [$soaps[0]];
            ! empty($diagnosticArray) ? $array['DIAGNOSTICEXAMRESULTS'] = [$diagnosticArray] : null;
            $array['MEDICINES'] = [$soaps[1]];

            $result = new ArrayToXml($array, $root, true, 'UTF-8');
            $xml = $result->dropXmlDeclaration()->toXml();

            $this->storeXml($transmittalNumber, $xml, $tranche, $enlistmentCount, $profileCount, $soapCount, $save, $effectivityYear, $credential);
            // return $xml;
        });

    }

    public function saveTransmittal($transmittalNumber, $tranche, $enlistmentCount, $profileCount, $soapCount, $xmlUrl, $report, $status, $effectivityYear)
    {
        $randomUser = User::query()
            ->where('facility_code', 'DOH000000000048882')
            ->where('is_active', 1)
            ->where('designation_code', '!=', 'MD')
            ->whereIn('id', ['9b0662cd-29d5-401d-81da-118bdefacb3a', '9b54822e-f4d2-44db-b44a-a8011570837a', '9b0662eb-5d19-4641-b73d-6a289570b115'])
            ->inRandomOrder()->first();

        KonsultaTransmittal::updateOrCreate(
            ['transmittal_number' => $transmittalNumber],
            ['user_id' => $randomUser->id, 'facility_code' => 'DOH000000000048882', 'total_enlistment' => $enlistmentCount, 'tranche' => $tranche, 'total_profile' => $profileCount, 'total_soap' => $soapCount, 'xml_url' => $xmlUrl, 'xml_status' => $status, 'xml_errors' => $report, 'effectivity_year' => $effectivityYear]
        );
    }

    public function storeXml($transmittalNumber, $xml, $tranche, $enlistmentCount, $profileCount, $soapCount, $save = false, $effectivityYear = null, $credential = null)
    {
        $service = new SampleSoapService();
        if ($save) {
            $fileName = 'Konsulta/'.$credential->facility_code.'/'.$tranche.$credential->accreditation_number.'_'.date('Ymd').'_'.$transmittalNumber.'.xml.enc';
            Storage::disk('spaces')->put($fileName, $service->encryptData($xml));
            $xmlEnc = Storage::disk('spaces')->get($fileName);
            /* try {
                // Check if the storage disk is available
                if (!Storage::disk('spaces')->exists('')) {
                    throw new \Exception('Storage disk is not accessible.');
                }

                // Attempt to save the file
                Storage::disk('spaces')->put($fileName, $service->encryptData($xml));

                // Attempt to retrieve the saved file
                $xmlEnc = Storage::disk('spaces')->get($fileName);
            } catch (\Exception $e) {
                // Log the error and prevent further execution
                Log::error('Error accessing storage disk: ' . $e->getMessage());
                return false;
            } */
        }

        $report = $service->soapMethod('validateReport', ['pReport' => $xmlEnc ?? $service->encryptData($xml), 'pReportTagging' => $tranche]);

        if ($save) {
            if ($effectivityYear === null) {
                $effectivityYear = date('Y');
            }
            $this->saveTransmittal($transmittalNumber, $tranche, $enlistmentCount, $profileCount, $soapCount, $fileName, $report, ! empty($report->success) ? 'V' : 'F', $effectivityYear);
        }

        //return $report;
    }

    public function enlistments($transmittalNumber = '', $patientId = [], $save = false, $revalidate = false, $effectivityYear = null, $tranche = 1)
    {
        if ($effectivityYear === null) {
            $effectivityYear = date('Y');
        }
        if ($revalidate && !empty($transmittalNumber) && $tranche == 2) {
            $patientId = Consult::query()->whereTransmittalNumber($transmittalNumber)->get()->pluck('patient_id');
        }
        $enlistments = [];
        $patient = Patient::selectRaw('id AS patientID, case_number, first_name, middle_name, last_name, suffix_name, gender, birthdate, mobile_number, consent_flag');
        $user = User::selectRaw('id AS userID, CONCAT(first_name, " ", last_name) AS created_by');
        $konsulta = KonsultaRegistrationList::selectRaw('philhealth_id AS pin_id, effectivity_year, suffix_name AS patient_suffix_name, member_suffix_name AS konsulta_member_suffix_name');
        $data = PatientPhilhealth::query()
            ->joinSub($patient, 'patients', function ($join) {
                $join->on('patient_philhealth.patient_id', '=', 'patients.patientID');
            })
            ->joinSub($user, 'users', function ($join) {
                $join->on('patient_philhealth.user_id', '=', 'users.userID');
            })
            ->leftJoinSub($konsulta, 'konsulta_registration_lists', function ($join) {
                $join->on('patient_philhealth.philhealth_id', '=', 'konsulta_registration_lists.pin_id')
                    ->whereColumn('patient_philhealth.effectivity_year', '=', 'konsulta_registration_lists.effectivity_year');
            })
            ->where('patient_philhealth.effectivity_year', $effectivityYear)
            ->whereIn('membership_type_id', ['MM', 'DD'])
            ->when(! empty($patientId), fn ($query) => $query->whereIn('patient_id', $patientId))
            ->when($revalidate && $tranche == 1, fn ($query) => $query->where('transmittal_number', $transmittalNumber))
            //->wherePatientId('97a9157e-2705-4a10-b68d-211052b0c6ac')
            ->get();
        $data->when($save && $tranche == 1, fn ($query) => $query->map(fn ($data, $key) => $data->update(['transmittal_number' => $transmittalNumber]))
        );
        $enlistments['ENLISTMENT'] = [EnlistmentResource::collection($data->whenEmpty(fn () => [[]]))->resolve()];

        return $enlistments;
    }

    public function profilings($transmittalNumber = '', $patientId = [], $revalidate = false, $effectivityYear = null, $tranche = 1)
    {
        if ($effectivityYear === null) {
            $effectivityYear = date('Y');
        }
        if ($revalidate && !empty($transmittalNumber) && $tranche == 2) {
            $patientId = Consult::query()->whereTransmittalNumber($transmittalNumber)->get()->pluck('patient_id');
        }
        $profile = [];
        $data = Patient::query()
            ->with([
                'patientHistorySpecifics',
                'familyHistory:patient_id,medical_history_id',
                'familyHistorySpecifics',
                'surgicalHistory',
                'socialHistory',
                'menstrualHistory',
            ])
            ->withWhereHas('patientHistory:patient_id,medical_history_id')
            ->withWhereHas('philhealthLatest', fn ($query) => [
                $query->whereIn('membership_type_id', ['MM', 'DD']),
                $query->when($revalidate && $tranche == 1, fn ($query) => $query->where('transmittal_number', $transmittalNumber)),
                $query->where('patient_philhealth.effectivity_year', $effectivityYear)
            ])
            ->when(! empty($patientId), fn ($query) => $query->whereIn('id', $patientId))
            //->whereId('97a9157e-2705-4a10-b68d-211052b0c6ac')
            ->get();
        /*$laboratory = ConsultLaboratory::query()
            ->where(fn($query) =>
                $query->whereHas('fbs')
                ->orWhereHas('rbs')
            )
            ->whereIn('lab_code', ['FBS', 'RBS'])
            ->whereIn('patient_id', $data->pluck('id'))
            ->get();*/
        $laboratory = Patient::query()
            ->whereIn('id', $data->pluck('id'))
            /*->whereHas('philhealthLatest', fn($query) => [
                $query->join('consult_laboratories', function($join){
                    $join->on('consult_laboratories.patient_id', '=', 'patient_philhealth.patient_id');
                    $join->where(DB::raw("DATE_FORMAT(consult_laboratories.request_date, '%Y-%m-%d')"), "=", DB::raw("DATE_FORMAT(patient_philhealth.enlistment_date, '%Y-%m-%d')"));
                })
            ])*/
            ->get();
        //dump($laboratory);
        $profileResource = ProfileResource::collection($data->whenEmpty(fn () => [[]]))->resolve();
        $diagnosticExamResource = DiagnosticExamResultResource::collection($laboratory->whenEmpty(fn () => [[]]))->resolve();

        $profile[0]['PROFILE'] = [$profileResource];
        $profile[1]['DIAGNOSTICEXAMRESULT'] = [$diagnosticExamResource];

        return $profile;
    }

    public function soaps($transmittalNumber = '', $patientId = [], $tranche = 2, $save = false, $revalidate = false, $effectivityYear = null, $credential = null)
    {
        $soap = [];
        $data = [];
        $medicine = [];
        $noMedicine = [];
        $laboratory = [];
        if ($tranche == 2) {
            $data = Consult::query()
                ->with(['patient', 'vitalsLatest', 'consultLaboratory'])
                ->withWhereHas('finalDiagnosis')
                ->withWhereHas('philhealthLatest', fn ($query) => $query->whereIn('membership_type_id', ['MM', 'DD']))
                ->when($revalidate, fn ($query) => $query->where('transmittal_number', $transmittalNumber))
                ->when($revalidate == false, fn ($query) => $query->whereNull('transmittal_number'))
                ->whereFacilityCode($credential->facility_code)
                ->whereYear('consult_date', $effectivityYear)
                ->where('is_konsulta', 1)
                ->wherePtGroup('cn')
                ->when(! empty($patientId), fn ($query) => $query->whereIn('patient_id', $patientId))
                ->get();
            //->wherePatientId('97a9157e-2705-4a10-b68d-211052b0c6ac')

            $medicine = MedicinePrescription::query()
                ->whereIn('consult_id', $data->pluck('id'))
                ->withSum('dispensing', 'dispense_quantity')
                ->withSum('dispensing', 'unit_price')
                ->withSum('dispensing', 'total_amount')
                ->with('dispensing', 'user')
                ->get();
            $noMedicine = Consult::query()
                ->whereIn('id', $data->pluck('id'))
                ->whereDoesntHave('prescription')
                ->get();

            $laboratory = Consult::query()
                ->whereIn('id', $data->pluck('id'))
                ->withWhereHas('consultLaboratory', fn ($query) => $query->whereHas('fbs')
                    ->orWhereHas('rbs')
                    ->orWhereHas('cbc')
                    ->orWhereHas('creatinine')
                    ->orWhereHas('chestXray')
                    ->orWhereHas('ecg')
                    ->orWhereHas('hba1c')
                    ->orWhereHas('papsmear')
                    ->orWhereHas('ppd')
                    ->orWhereHas('sputum')
                    ->orWhereHas('fecalysis')
                    ->orWhereHas('lipiProfile')
                    ->orWhereHas('urinalysis')
                    ->orWhereHas('oralGlucose')
                    ->orWhereHas('fecalOccult')
                )
                ->get();
            $data->when($save, fn ($query) => $data->map(fn ($data, $key) => $data->update(['transmittal_number' => $transmittalNumber]))
            );
        }
        $soapResource = ConsultationResource::collection(! empty($data) ? $data->whenEmpty(fn () => [[]]) : [[]]);
        $medicineResource = MedicineResource::collection(! empty($medicine) ? $medicine->whenEmpty(fn () => [[]]) : [[]]);
        $noMedicineResource = NoMedicineResource::collection(! empty($noMedicine) ? $noMedicine->whenEmpty(fn () => [[]]) : [[]]);
        $laboratoryResource = SoapDiagnosticExamResultResource::collection(! empty($laboratory) ? $laboratory->whenEmpty(fn () => [[]]) : [[]]);

        $soap[0]['SOAP'] = [$soapResource->resolve()];

        if ($tranche == 2) {
            $soap[1]['MEDICINE'] = array_filter([count($medicine) != 0 ? $medicineResource->resolve() : '', count($noMedicine) != 0 ? $noMedicineResource->resolve() : '']);
        } else {
            $soap[1]['MEDICINE'] = [$medicineResource->resolve()];
        }
        ! empty($laboratory) ? $soap[2]['DIAGNOSTICEXAMRESULT'] = [$laboratoryResource->resolve()] : null;

        return $soap;
    }
}
