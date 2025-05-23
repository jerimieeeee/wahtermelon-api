<?php

namespace App\Http\Controllers\API\V1\Konsulta;

use App\Classes\PhilHealthEClaimsEncryptor;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Konsulta\KonsultaTransmittalResource;
use App\Http\Resources\API\V1\Patient\PatientPhilhealthResource;
use App\Http\Resources\API\V1\PhilHealth\GetTokenResource;
use App\Models\User;
use App\Models\V1\Konsulta\KonsultaImport;
use App\Models\V1\Konsulta\KonsultaTransmittal;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientPhilhealth;
use App\Services\Konsulta\KonsultaMigrationService;
use App\Services\PhilHealth\KonsultaService;
use App\Services\PhilHealth\SoapService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

/**
 * @authenticated
 *
 * @group Konsulta Information
 *
 * APIs for managing Konsulta Information
 *
 * @subgroup Konsulta
 *
 * @subgroupDescription Konsulta.
 */
class KonsultaController extends Controller
{
    public function index(SoapService $service, KonsultaService $konsultaService)
    {
        //return $service->soapMethod('extractRegistrationList', ['pStartDate' => '12/09/2022', 'pEndDate' => '12/31/2022']);
        $firstTranche = $konsultaService->generateXml();
        $data = $service->encryptData($firstTranche);

        return $service->soapMethod('validateReport', ['pReport' => $data, 'pReportTagging' => 1]);
    }

    /**
     * getToken
     *
     * @return Exception|mixed
     */
    public function getToken(SoapService $service): mixed
    {
        $credentials = auth()->user()->konsultaCredential;
        $credentialsResource = GetTokenResource::make($credentials)->resolve();
        $result = $service->soapMethod('getToken', $credentialsResource);
        if (isset($result->success)) {
            $result = (array) $result;
            $credentials->update(['token' => $result['result']]);

            return response()->json([
                'message' => 'Successfully added the token in the database!',
            ], 201);
        }

        return response()->json($result, 200);
    }

    /**
     * extractRegistrationList
     *
     * @queryParam pStartDate date Start date format mm/dd/YYYY. Example: 01/01/2022
     * @queryParam pEndDate date End date format mm/dd/YYYY. Example: 12/31/2022
     *
     * @return Exception|mixed
     */
    public function extractRegistrationList(Request $request, SoapService $service)
    {
        $list = $service->soapMethod('extractRegistrationList', $request->only('pStartDate', 'pEndDate'));
        try {
            // Your code logic here...
            if (empty($list)) {
                return response()->json(
                    [
                        'code' => 404,
                        'message' => "No Records Found!"
                    ]
                , 404);
                //throw new \Exception('No Records Found!', 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
        if (isset($list->ASSIGNMENT)) {
            $service->saveRegistrationList(array_filter(!is_array($list->ASSIGNMENT) ? [$list->ASSIGNMENT] : $list->ASSIGNMENT));
        }

        return $list;
    }

    /**
     * isMemberDependentRegistered
     *
     * @queryParam pPIN string Patient PIN. Example: 0123456789123
     * @queryParam pType string Type. Example: MM
     *
     * @return Exception|mixed
     */
    public function checkRegistered(Request $request, SoapService $service): mixed
    {
        return $service->soapMethod('isMemberDependentRegistered', $request->only('pPIN', 'pType'));
    }

    /**
     * isATCValid
     *
     * @queryParam pPIN string Patient PIN. Example: 0123456789123
     * @queryParam pATC string Type. Example: abcdefghij
     * @queryParam pEffectivityDate date End date format mm/dd/YYYY. Example: 01/01/2022
     *
     * @return Exception|mixed
     */
    public function checkATC(Request $request, SoapService $service): mixed
    {
        return $service->soapMethod('isATCValid', $request->only('pPIN', 'pATC', 'pEffectivityDate'));
    }

    /**
     * List of Patients for Generation of XML.
     *
     * @queryParam tranche string Filter by tranche. e.g. 1 or 2 Example: 1
     * @queryParam effectivity_year string Filter by effectivity year. e.g. 2023 Example: 2023
     * @queryParam include string Relationship to view: e.g. facility,user Example: facility,user
     * @queryParam sort string Sort created_at. Add hyphen (-) to descend the list: e.g. created_at. Example: created_at
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Patient\PatientPhilhealthResource
     *
     * @apiResourceModel App\Models\V1\Patient\PatientPhilhealth paginate=15
     *
     * @return ResourceCollection
     */
    public function generateDataForValidation(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $columns = ['last_name', 'first_name', 'middle_name'];
//        $data = QueryBuilder::for(PatientPhilhealth::class)
//            ->whereEffectivityYear($request->effectivity_year)
//            ->withWhereHas('konsultaRegistration', fn ($query) => $query->whereEffectivityYear($request->effectivity_year))
//            ->withWhereHas('patient.patientHistory')
//            ->when(isset($request->search), function ($q) use ($request, $columns) {
//                //$q->search($request->filter['search'], $columns);
//                $q->whereHas('patient', function ($q) use ($request, $columns) {
//                    $q->orSearch($columns, 'LIKE', $request->search);
//                });
//            })
//            ->when($request->tranche == 1,
//                fn ($query) => $query->whereNull('transmittal_number')
//            )
//            ->when($request->tranche == 2,
//                fn ($query) =>
//                    //$query->whereNotNull('transmittal_number'),
//                    $query->withWhereHas('patient.consult', fn ($q) => $q->whereNull('transmittal_number')->where('is_konsulta', 1)->wherePtGroup('cn')->whereHas('patient.consult.finalDiagnosis'))
//
//            )
//            ->whereIn('membership_type_id', ['MM', 'DD'])
        $data = QueryBuilder::for(PatientPhilhealth::class)
            ->whereEffectivityYear($request->effectivity_year)
            ->withWhereHas('konsultaRegistration', fn ($query) => $query->whereEffectivityYear($request->effectivity_year)->whereFacility_code(auth()->user()->facility_code))
            ->withWhereHas('patient.patientHistory')
            ->when(isset($request->search), function ($q) use ($request, $columns) {
                $q->whereHas('patient', fn ($q) => $q->orSearch($columns, 'LIKE', $request->search));
            })
            ->when($request->tranche == 1, fn ($query) => $query->whereNull('transmittal_number'))
            ->when($request->tranche == 2, function ($query) use($request){
                $query->withWhereHas('patient.consult', function ($q) use($request){
                    $q->whereNull('transmittal_number')->where('is_konsulta', 1)
                        ->where('facility_code', auth()->user()->facility_code)
                        ->whereYear('consult_date', $request->effectivity_year)
                        ->wherePtGroup('cn')
                        ->whereHas('finalDiagnosis');
                });
            })
            ->whereIn('membership_type_id', ['MM', 'DD'])
            ->allowedIncludes('facility', 'user')
            ->defaultSort('-effectivity_year', 'created_at')
            ->allowedSorts(['effectivity_year', 'created_at']);

        if ($perPage === 'all') {
            return PatientPhilhealthResource::collection($data->get());
        }

        return PatientPhilhealthResource::collection($data->paginate($perPage)->withQueryString());
    }

    /**
     * Display a listing of the Konsulta Transmittal resource.
     *
     * @queryParam filter[tranche] string Filter by tranche. e.g. 1 or 2 Example: 1
     * @queryParam filter[xml_status] string Filter by xml_status. e.g. V,F or S Example: V
     * @queryParam include string Relationship to view: e.g. facility,user,patient Example: facility,user,patient
     * @queryParam sort string Sort created_at. Add hyphen (-) to descend the list: e.g. created_at. Example: created_at
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Konsulta\KonsultaTransmittalResource
     *
     * @apiResourceModel App\Models\V1\Konsulta\KonsultaTransmittal paginate=15
     */
    public function validatedXml(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $columns = ['last_name', 'first_name', 'middle_name'];
        /* if ($request->reconcillation) {
            $data = QueryBuilder::for(KonsultaTransmittal::class)
            ->when($request->filter['tranche'] == 1 && (isset($request->search) && !empty($request->search)), function ($query) use($columns, $request){
                $query->whereHas('patientPhilhealth', fn ($q) => $q->orSearch($columns, 'LIKE', $request->search));
            })
            ->when($request->filter['tranche'] == 2 && (isset($request->search) && !empty($request->search)), function ($query) use($columns, $request){
                $query->whereHas('patientConsult', fn ($q) => $q->orSearch($columns, 'LIKE', $request->search));
            })
            ->when(isset($request->effectivity_year) && !empty($request->effectivity_year), function ($query) use($request) {
                $query->where('konsulta_transmittals.effectivity_year', $request->effectivity_year);
            })
            ->leftJoin('consults as c', function ($join) {
                $join->on('konsulta_transmittals.transmittal_number', '=', 'c.transmittal_number')
                     ->where('konsulta_transmittals.tranche', '=', 2);
            })
            ->leftJoin('patient_philhealth as pp', function ($join) {
                $join->on('konsulta_transmittals.transmittal_number', '=', 'pp.transmittal_number')
                     ->where('konsulta_transmittals.tranche', '=', 1);
            })
            ->leftJoin('patients as p', function ($join) {
                $join->on('p.id', '=', DB::raw('COALESCE(c.patient_id, pp.patient_id)'));
            })
            ->leftJoin('patient_philhealth as main_pp', function ($join) {
                $join->on('main_pp.patient_id', '=', 'p.id')
                     ->where('main_pp.effectivity_year', '=', DB::raw('konsulta_transmittals.effectivity_year'));
            })
            ->select([
                'p.case_number',
                'p.id as patient_id',
                DB::raw('COALESCE(pp.philhealth_id, main_pp.philhealth_id) as philhealth_id'),
                'pp.enlistment_date',
                'konsulta_transmittals.id as transmittal_id',
                'konsulta_transmittals.transmittal_number',
                'konsulta_transmittals.tranche',
                'konsulta_transmittals.xml_status',
                DB::raw('COALESCE(c.consult_date, NULL) as consult_date'),



            ])
            ->get();
            return $data;
        } */
        /* $mainPhilhealth = PatientPhilhealth::query()
            ->selectRaw('id, philhealth_id, effectivity_year, enlistment_date, transmittal_number as transmittal_number, patient_id as patient_id')
            ->whereNotNull('transmittal_number')
            ->groupBy('philhealth_id', 'effectivity_year'); */
        $data = QueryBuilder::for(KonsultaTransmittal::class)
            //->whereNull('konsulta_transaction_number')
            ->when($request->reconcillation, function ($query) {
                $query->leftJoin('consults as c', function ($join) {
                    $join->on('konsulta_transmittals.transmittal_number', '=', 'c.transmittal_number')
                         ->where('konsulta_transmittals.tranche', '=', 2);
                })
                ->leftJoin('patient_philhealth as pp', function ($join) {
                    $join->on('konsulta_transmittals.transmittal_number', '=', 'pp.transmittal_number')
                         ->where('konsulta_transmittals.tranche', '=', 1);
                })
                ->leftJoin('patients as p', function ($join) {
                    $join->on('p.id', '=', DB::raw('COALESCE(c.patient_id, pp.patient_id)'));
                })
                // ->leftJoinSub($mainPhilhealth, 'main_pp', function ($join) {
                //     $join->on('main_pp.patient_id', '=', 'p.id')
                //          ->whereColumn('main_pp.effectivity_year', 'konsulta_transmittals.effectivity_year');
                // })
                /* ->leftJoin('patient_philhealth as main_pp', function ($join) {
                    $join->on('main_pp.patient_id', '=', 'p.id')
                         ->where('main_pp.effectivity_year', '=', DB::raw('konsulta_transmittals.effectivity_year'));
                }) */;
                $query->addSelect([
                    'konsulta_transmittals.*',
                    'p.case_number',
                    'c.consult_date',
                    // 'main_pp.philhealth_id',
                    // 'main_pp.enlistment_date',
                    DB::raw("CASE
                        WHEN konsulta_transmittals.tranche = 2 AND EXISTS (
                            SELECT 1 FROM consult_laboratories cl
                            WHERE cl.consult_id = c.id
                            AND cl.deleted_at IS NULL
                            AND (
                                EXISTS (SELECT 1 FROM consult_laboratory_fbs WHERE consult_laboratory_fbs.consult_id = cl.consult_id AND consult_laboratory_fbs.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_rbs WHERE consult_laboratory_rbs.consult_id = cl.consult_id AND consult_laboratory_rbs.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_cbcs WHERE consult_laboratory_cbcs.consult_id = cl.consult_id AND consult_laboratory_cbcs.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_creatinines WHERE consult_laboratory_creatinines.consult_id = cl.consult_id AND consult_laboratory_creatinines.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_chest_xrays WHERE consult_laboratory_chest_xrays.consult_id = cl.consult_id AND consult_laboratory_chest_xrays.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_ecgs WHERE consult_laboratory_ecgs.consult_id = cl.consult_id AND consult_laboratory_ecgs.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_hba1cs WHERE consult_laboratory_hba1cs.consult_id = cl.consult_id AND consult_laboratory_hba1cs.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_papsmears WHERE consult_laboratory_papsmears.consult_id = cl.consult_id AND consult_laboratory_papsmears.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_ppds WHERE consult_laboratory_ppds.consult_id = cl.consult_id AND consult_laboratory_ppds.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_sputum WHERE consult_laboratory_sputum.consult_id = cl.consult_id AND consult_laboratory_sputum.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_fecalysis WHERE consult_laboratory_fecalysis.consult_id = cl.consult_id AND consult_laboratory_fecalysis.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_lipid_profiles WHERE consult_laboratory_lipid_profiles.consult_id = cl.consult_id AND consult_laboratory_lipid_profiles.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_urinalysis WHERE consult_laboratory_urinalysis.consult_id = cl.consult_id AND consult_laboratory_urinalysis.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_oral_glucose WHERE consult_laboratory_oral_glucose.consult_id = cl.consult_id AND consult_laboratory_oral_glucose.deleted_at IS NULL) OR
                                EXISTS (SELECT 1 FROM consult_laboratory_fecal_occults WHERE consult_laboratory_fecal_occults.consult_id = cl.consult_id AND consult_laboratory_fecal_occults.deleted_at IS NULL)
                            )
                        ) THEN 'Yes' ELSE 'No' END AS with_laboratory"),
                    DB::raw("CASE
                        WHEN konsulta_transmittals.tranche = 2 AND EXISTS (
                            SELECT 1 FROM medicine_prescriptions mp
                            WHERE mp.consult_id = c.id
                            AND mp.deleted_at IS NULL
                        )
                        THEN DATE_FORMAT(c.consult_date, '%Y-%m-%d') ELSE NULL END AS epress_date"),
                ]);
            })
            ->when((isset($request->start_date) && !empty($request->start_date)) && (isset($request->end_date) && !empty($request->end_date)), fn ($query) => $query->whereRaw('DATE(konsulta_transmittals.updated_at) BETWEEN ? AND ?', [$request->start_date, $request->end_date]))
            ->when($request->filter['tranche'] == 1 && (isset($request->search) && !empty($request->search)), function ($query) use($columns, $request){
                $query->whereHas('patientPhilhealth', fn ($q) => $q->orSearch($columns, 'LIKE', $request->search));
            })
            ->when($request->filter['tranche'] == 2 && (isset($request->search) && !empty($request->search)), function ($query) use($columns, $request){
                $query->whereHas('patientConsult', fn ($q) => $q->orSearch($columns, 'LIKE', $request->search));
            })
            ->when(isset($request->effectivity_year) && !empty($request->effectivity_year), function ($query) use($request) {
                // $query->whereEffectivityYear($request->effectivity_year);
                $query->where('konsulta_transmittals.effectivity_year', $request->effectivity_year);
            })
            ->allowedIncludes('facility', 'user')
            ->allowedFilters('tranche', 'xml_status')
            ->defaultSort('konsulta_transmittals.created_at')
            ->allowedSorts(['konsulta_transmittals.created_at']);
            // return $data->get();
            // return $data->paginate($perPage)->withQueryString();
            // return $data->count();
        if ($perPage === 'all') {
            return KonsultaTransmittalResource::collection($data->get());
        }

        return KonsultaTransmittalResource::collection($data->paginate($perPage)->withQueryString());
    }

    /**
     * Generate and Validate XML
     *
     * @queryParam transmittal_number string Filter by transmittal number. Example: RP9103406820230100001
     * @queryParam patient_id string Filter by transmittal number.
     * @queryParam tranche string Filter by trance number e.g. 1 or 2. Example: 1
     * @queryParam save boolean Filter by revalidate e.g. 0 or 1. Example: 0
     * @queryParam revalidate boolean Filter by revalidate e.g. 0 or 1. Example: 0
     *
     * @return Exception|mixed
     */
    public function validateReport(Request $request, SoapService $service, KonsultaService $konsultaService): mixed
    {
        //return $service->httpClient();
        //return $service->soapMethod('checkUploadStatus', []);
        //$firstTranche = $konsultaService->generateXml();
        return $firstTranche = $konsultaService->createXml($request->transmittal_number ?? '', $request->patient_id ?? [], $request->tranche, $request->save, $request->revalidate, $request->effectivity_year);
        //$data = $service->encryptData($firstTranche);
        //return $service->soapMethod('submitReport', ['pTransmittalID' => 'RP9103406820221200001', 'pReport' => $data, 'pReportTagging' =>1]);
        //$contents = Storage::disk('spaces')->get('Konsulta/DOH000000000005173/1P91034068_20230109_RP9103406820230100001.xml.enc');
        //return $service->soapMethod('validateReport', ['pReport' => $data, 'pReportTagging' => $request->tranche]);
    }

    /**
     * Submit Validated XML
     *
     * @queryParam transmittal_number string Filter by transmittal number. Example: RP9103406820230100001
     *
     * @return Exception|mixed
     */
    public function submitXml(Request $request, SoapService $service, KonsultaService $konsultaService)
    {
        $transactionNumber = null;
        $status = 'F';
        $data = KonsultaTransmittal::whereTransmittalNumber($request->transmittal_number)->first();
        $xmlEnc = Storage::disk('spaces')->get($data->xml_url);
        $submitted = $service->soapMethod('submitReport', ['pTransmittalID' => $data->transmittal_number, 'pReport' => $xmlEnc, 'pReportTagging' => $data->tranche]);
        if (isset($submitted->success) && ! empty($submitted->uploadxmlresult)) {
            $transactionNumber = $submitted->uploadxmlresult->transactionno;
            $status = 'S';
        }
        if (isset($submitted->transactionno)) {
            $transactionNumber = $submitted->transactionno;
            $status = 'S';
        }
        $data->update(['konsulta_transaction_number' => $transactionNumber, 'xml_status' => $status, 'xml_errors' => $submitted]);

        return $submitted;
    }

    /**
     * Download XML
     *
     * @queryParam transmittal_number string Filter by transmittal number. Example: RP9103406820230100001
     * @queryParam konsulta_transaction_number string Filter by konsulta transaction number. Example: P9103406820230100001
     * @queryParam raw string Filter by file type e.g. 1 or 2. Example: 0
     */
    public function downloadXml(Request $request)
    {
        $konsulta = KonsultaTransmittal::query()
            ->when($request->transmittal_number, fn ($query) => $query->where('transmittal_number', $request->transmittal_number)
            )
            ->when($request->transaction_number, fn ($query) => $query->where('konsulta_transaction_number', $request->konsulta_transaction_number)
            )
            ->first();

        if (empty($konsulta)) {
            return 'File not found!';
        }

        $fileStorage = Storage::disk('spaces');

        if ($request->raw) {
            $fileContent = $fileStorage->get($konsulta->xml_url);
            $decryptor = new PhilHealthEClaimsEncryptor();
            $cipher_key = auth()->user()->konsultaCredential->cipher_key;

            return $decryptor->decryptPayloadDataToXml($fileContent, $cipher_key);
        }

        return $fileStorage->download($konsulta->xml_url);
    }

    /**
     * Upload XML
     *
     * @bodyParam xml file required The xml.
     *
     * @throws Throwable
     */
    public function uploadXml(Request $request, KonsultaMigrationService $migrationService)
    {
        throw_if(! request()->hasFile('xml'), 'No File to be uploaded');

        $file = $request->file('xml');

        if (! is_array($file)) {
            $fileContent = file_get_contents($file);
            $jsonXml = XML2JSON($fileContent);
            //KonsultaImport::updateOrCreate(['transmittal_number' => $jsonXml->pHciTransmittalNumber], ['enlistments' => $jsonXml->ENLISTMENTS, 'imported_xml' => $jsonXml]);
            return response()->json([
                'status' => 'File successfully uploaded',
            ], 201);
        }
        //$arrValue = [];
        foreach ($file as $key => $value) {
            $fileContent = file_get_contents($value);
            $decryptor = new PhilHealthEClaimsEncryptor();
            $cipher_key = $request->cipher_key;
            $data = $decryptor->decryptPayloadDataToXml($fileContent, $cipher_key);
            $arrValue[] = XML2JSON($data);
            //return $jsonXml->ENLISTMENTS;
            //KonsultaImport::updateOrCreate(['transmittal_number' => $jsonXml->pHciTransmittalNumber], ['enlistments' => $jsonXml->ENLISTMENTS, 'imported_xml' => $jsonXml]);
        }

        return $migrationService->saveProfile(collect($arrValue));

        return response()->json([
            'status' => 'File successfully uploaded',
        ], 201);
    }

    /**
     * Generate Age with the difference of Two Dates
     *
     * @bodyParam date_from date From date format Y-m-d. Example: 2022-01-01
     * @bodyParam date_to date To date format Y-m-d. Example: 2023-01-31
     *
     * @return JsonResponse
     */
    public function getAge(Request $request)
    {
        //return json_encode($request->xml);
        /*$decryptor = new PhilHealthEClaimsEncryptor();
        $cipher_key = auth()->user()->konsultaCredential->cipher_key;
        return $decryptor->decryptPayloadDataToXml($request->xml, $cipher_key);*/
        $request->validate([
            'date_from' => 'required|date|date_format:Y-m-d',
            'date_to' => 'required|date|date_format:Y-m-d',
        ]);
        $age = Carbon::parse($request->date_from)->diff($request->date_to)->y.' YR(S), '.Carbon::parse($request->date_from)->diff($request->date_to)->m.' MO(S), '.Carbon::parse($request->date_from)->diff($request->date_to)->d.' DAY(S)';

        return response()->json(['data' => $age]);
    }

    /**
     * Upload Registration List
     *
     * @bodyParam xml file required The xml.
     *
     * @throws Throwable
     */
    public function uploadRegistrationList(Request $request, SoapService $service)
    {
        throw_if(!$request->hasFile('xml'), 'No File to be uploaded');

        $file = $request->file('xml');
        $arrValue = [];

        if (!is_array($file)) {
            $arrValue[] = $this->processFile($file, $service, $request->cipher_key);
        } else {
            foreach ($file as $value) {
                $arrValue[] = $this->processFile($value, $service, $request->cipher_key);
            }
        }

        return response()->json([
            'status' => 'File successfully uploaded',
        ], 201);
    }

    private function processFile($file, $service, $cipherKey)
    {
        $fileContent = file_get_contents($file);
        $decryptor = new PhilHealthEClaimsEncryptor();
        $data = $decryptor->decryptPayloadDataToXml($fileContent, $cipherKey);
        $list = XML2JSON($data);

        if (!isset($list->ASSIGNMENT)) {
            throw new \Exception('ASSIGNMENT key not found in the XML data');
        }

        $service->saveRegistrationList(array_filter($list->ASSIGNMENT));

        return $list;
    }
}
