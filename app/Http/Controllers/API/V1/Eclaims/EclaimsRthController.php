<?php

namespace App\Http\Controllers\API\V1\Eclaims;


use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Eclaims\EclaimsRthRequest;
use App\Http\Resources\API\V1\Eclaims\EclaimsRthResource;
use App\Models\V1\Eclaims\EclaimsRth;
use App\Models\V1\Eclaims\EclaimsRthDocument;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Services\PhilHealth\SoapService;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;
use Spatie\ArrayToXml\ArrayToXml;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class EclaimsRthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $columns = ['last_name', 'first_name', 'middle_name'];
        $query = QueryBuilder::for(EclaimsRth::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->when(isset($request->program_desc), function ($q) use ($request) {
                $q->where('program_desc', $request->program_desc);
            })
            ->when(isset($request->pStatus), function ($q) use ($request) {
                if($request->pStatus == 'TRANSMITTED') {
                    $q->whereNotNull('pTransmissionControlNumber');
                } else {
                    $q->where('pStatus', $request->pStatus);
                }
            })
            ->when(isset($request->filter['search']), function ($q) use ($request, $columns) {
                $q->whereHas('patient', function ($q) use ($request, $columns) {
                    $q->orSearch($columns, 'LIKE', $request->filter['search']);
                });
            })
            ->when(isset($request->code), function ($q) use ($request) {
                $q->whereHas('caserate', function ($q) use ($request) {
                    $q->where('code', $request->code);
                });
            })
            ->when(isset($request->start_date) && ! isset($request->end_date), function ($q) use ($request) {
                $q->where('pTransmissionDate', '>=', $request->start_date);
            })
            ->when(! isset($request->start_date) && isset($request->end_date), function ($q) use ($request) {
                $q->where('pTransmissionDate', '<=', $request->end_date);
            })
            ->when(isset($request->start_date) && isset($request->end_date), function ($q) use ($request) {
                $q->whereBetween('pTransmissionDate', [$request->start_date, $request->end_date]);
            })
            ->with(['patient', 'patient.philhealthLatest', 'caserate', 'caserate.attendant',
                'caserate.patientAb', 'caserate.patientAb.abPostExposure',
                'caserate.patientCc',
                'caserate.patientMc', 'caserate.patientMc.prenatal', 'caserate.patientMc.postRegister',
                'caserate.patientTb', 'caserate.patientTb.tbCaseHolding'])
            ->defaultSort('-created_at')
            ->allowedSorts('created_at');

        if ($perPage === 'all') {
            return EclaimsRthResource::collection($query->get());
        }

        return EclaimsRthResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = EclaimsRth::updateOrCreate(
            [
                'pHospitalTransmittalNo' => $request->pHospitalTransmittalNo,
            ],
            $request->only([
                'pClaimSeriesLhio',
                'pStatus',
                'denied_reason',
                'return_reason',
                'pTransmissionDate',
                'pTransmissionTime',
                'pCheckDate',
                'isSuccess',
            ])
        );

        return response()->json(['data' => $data, 'status' => 'Success'], 201);

    }

    public function createRequiredXml(EclaimsRthRequest $request)
    {
        $message = '';

        $documents = EclaimsRthDocument::where('pHospitalTransmittalNo', $request->pHospitalTransmittalNo)
                    ->where('required', 'Y')
                    ->get();

        if ($documents) {
            $service = new SoapService();
            $creds = PhilhealthCredential::where('facility_code', auth()->user()->facility_code)
                ->where('program_code', ($request->program_desc == 'cc' || $request->program_desc == 'fp' ? 'mc' : $request->program_desc))
                ->first();

            $eClaimsXMLDocs = '<DOCUMENTS>';
            foreach ($documents as $key => $value) {
                $eClaimsXMLDocs .= "<DOCUMENT pDocumentType='".$value['doc_type_code']."' pDocumentURL='".$value['doc_url']."'/>";
            }
            $eClaimsXMLDocs .= '</DOCUMENTS>';

            $encryptedXml = $service->encryptData($eClaimsXMLDocs, $creds->cipher_key);

            $path = 'Eclaims/'.auth()->user()->facility_code.'/'.$request->pHospitalTransmittalNo.'/'.$request->pHospitalTransmittalNo.'-required.xml';
            Storage::disk('spaces')->put($path.'.enc', $encryptedXml, ['visibility' => 'public', 'ContentType' => 'application/octet-stream']);

            $message = 'Created Successfully!';
        } else {
            $message = 'No Document Found!';
        }

        return response()->json([
            'message' => $message,
            'xml' => $encryptedXml
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
