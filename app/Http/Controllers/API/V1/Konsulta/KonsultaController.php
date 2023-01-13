<?php

namespace App\Http\Controllers\API\V1\Konsulta;

use App\Classes\PhilHealthEClaimsEncryptor;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Konsulta\EnlistmentResource;
use App\Http\Resources\API\V1\Konsulta\KonsultaTransmittalResource;
use App\Http\Resources\API\V1\Patient\PatientPhilhealthResource;
use App\Http\Resources\API\V1\PhilHealth\GetTokenResource;
use App\Models\User;
use App\Models\V1\Konsulta\KonsultaTransmittal;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientPhilhealth;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Services\PhilHealth\KonsultaService;
use App\Services\PhilHealth\SoapService;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Spatie\ArrayToXml\ArrayToXml;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Konsulta Information
 *
 * APIs for managing Konsulta Information
 * @subgroup Konsulta
 * @subgroupDescription Konsulta.
 */
class KonsultaController extends Controller
{
    public function index(SoapService $service, KonsultaService $konsultaService)
    {
        //return $service->soapMethod('extractRegistrationList', ['pStartDate' => '12/09/2022', 'pEndDate' => '12/31/2022']);
        $firstTranche = $konsultaService->generateXml();
        $data = $service->encryptData($firstTranche);
        return $service->soapMethod('validateReport', ['pReport' => $data, 'pReportTagging' =>1]);

    }

    /**
     * getToken
     *
     * @param SoapService $service
     * @return Exception|mixed
     */
    public function getToken(SoapService $service): mixed
    {
        $credentials = auth()->user()->konsultaCredential;
        $credentialsResource = GetTokenResource::make($credentials)->resolve();
        $result = $service->soapMethod('getToken', $credentialsResource);
        if(isset($result->success)) {
            $credentials->update(['token' => $result->result]);
            return response()->json([
                'message' => 'Successfully added the token in the database!'
            ], 201);
        }
        return response()->json($result, 200);;
    }

    /**
     * extractRegistrationList
     *
     * @queryParam pStartDate date Start date format mm/dd/YYYY. Example: 01/01/2022
     * @queryParam pEndDate date End date format mm/dd/YYYY. Example: 12/31/2022
     * @param Request $request
     * @param SoapService $service
     * @return Exception|mixed
     */
    public function extractRegistrationList(Request $request, SoapService $service)
    {
        $list = $service->soapMethod('extractRegistrationList', $request->only('pStartDate', 'pEndDate'));
        $service->saveRegistrationList($list->ASSIGNMENT);
        return $list;
    }

    /**
     * isMemberDependentRegistered
     *
     * @queryParam pPIN string Patient PIN. Example: 0123456789123
     * @queryParam pType string Type. Example: MM
     * @param Request $request
     * @param SoapService $service
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
     * @param Request $request
     * @param SoapService $service
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
     * @apiResourceCollection App\Http\Resources\API\V1\Patient\PatientPhilhealthResource
     * @apiResourceModel App\Models\V1\Patient\PatientPhilhealth paginate=15
     * @return ResourceCollection
     */
    public function generateDataForValidation(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $data = QueryBuilder::for(PatientPhilhealth::class)
            ->whereEffectivityYear($request->effectivity_year)
            ->withWhereHas('konsultaRegistration', fn($query) => $query->whereEffectivityYear($request->effectivity_year))
            ->withWhereHas('patient.patientHistory')
            ->when($request->tranche == 1,
                fn($query) => $query->whereNull('transmittal_number')
            )
            ->when($request->tranche == 2,
                fn($query) => $query->withWhereHas('patient.consult', fn($q) => $q->whereNull('transmittal_number')->wherePtGroup('cn')->whereHas('patient.consult.finalDiagnosis'))
            )
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
     * @apiResourceCollection App\Http\Resources\API\V1\Konsulta\KonsultaTransmittalResource
     * @apiResourceModel App\Models\V1\Konsulta\KonsultaTransmittal paginate=15
     * @return ResourceCollection
     */
    public function validatedXml(): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $data = QueryBuilder::for(KonsultaTransmittal::class)
            //->whereNull('konsulta_transaction_number')
            ->allowedIncludes('facility', 'user', 'patient')
            ->allowedFilters('tranche', 'xml_status')
            ->defaultSort('created_at')
            ->allowedSorts(['created_at']);
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
     * @return Exception|mixed
     */
    public function validateReport(Request $request, SoapService $service, KonsultaService $konsultaService): mixed
    {
        //return $service->httpClient();
        //return $service->soapMethod('checkUploadStatus', []);
        //$firstTranche = $konsultaService->generateXml();
        return $firstTranche = $konsultaService->createXml($request->transmittal_number?? "", $request->patient_id?? [], $request->tranche , $request->save, $request->revalidate);
        //$data = $service->encryptData($firstTranche);
        //return $service->soapMethod('submitReport', ['pTransmittalID' => 'RP9103406820221200001', 'pReport' => $data, 'pReportTagging' =>1]);
        //$contents = Storage::disk('spaces')->get('Konsulta/DOH000000000005173/1P91034068_20230109_RP9103406820230100001.xml.enc');
        //return $service->soapMethod('validateReport', ['pReport' => $data, 'pReportTagging' => $request->tranche]);
    }

    /**
     * Submit Validated XML
     *
     * @queryParam transmittal_number string Filter by transmittal number. Example: RP9103406820230100001
     * @return Exception|mixed
     */
    public function submitXml(Request $request, SoapService $service, KonsultaService $konsultaService)
    {
        $transactionNumber = null;
        $status = 'F';
        $data = KonsultaTransmittal::whereTransmittalNumber($request->transmittal_number)->first();
        $xmlEnc = Storage::disk('spaces')->get($data->xml_url);
        $submitted = $service->soapMethod('submitReport', ['pTransmittalID' => $data->transmittal_number, 'pReport' => $xmlEnc, 'pReportTagging' => $data->tranche]);
        if(isset($submitted->success) && !empty($submitted->uploadxmlresult)) {
            $transactionNumber = $submitted->uploadxmlresult->transactionno;
            $status = 'S';
        }
        if(isset($submitted->transactionno)) {
            $transactionNumber = $submitted->transactionno;
            $status = 'S';
        }
        $data->update(['konsulta_transaction_number' => $transactionNumber, 'xml_status' => $status, 'xml_errors' => $submitted]);
        return $submitted;
    }

    /**
     * Submit Validated XML
     *
     * @queryParam transmittal_number string Filter by transmittal number. Example: RP9103406820230100001
     * @queryParam konsulta_transaction_number string Filter by konsulta transaction number. Example: P9103406820230100001
     */
    public function downloadXml(Request $request)
    {
        $konsulta = KonsultaTransmittal::query()
            ->when($request->transmittal_number, fn($query) =>
                $query->where('transmittal_number', $request->transmittal_number)
            )
             ->when($request->transaction_number, fn($query) =>
                $query->where('konsulta_transaction_number', $request->konsulta_transaction_number)
            )
            ->first();

        if(empty($konsulta)) {
            return 'File not found!';
        }

        $fileStorage = Storage::disk('spaces');

        if($request->raw) {
            $fileContent = $fileStorage->get($konsulta->xml_url);
            $decryptor = new PhilHealthEClaimsEncryptor();
            $cipher_key = auth()->user()->konsultaCredential->cipher_key;
            return $decryptor->decryptPayloadDataToXml($fileContent, $cipher_key);
        }
        return $fileStorage->download($konsulta->xml_url);
    }

}
