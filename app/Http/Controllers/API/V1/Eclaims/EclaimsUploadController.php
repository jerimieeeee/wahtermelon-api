<?php

namespace App\Http\Controllers\API\V1\Eclaims;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Eclaims\EclaimsUploadRequest;
use App\Http\Resources\API\V1\Eclaims\EclaimsUploadResource;
use App\Models\V1\Eclaims\EclaimsUpload;
use App\Models\V1\Eclaims\EclaimsUploadDocument;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Services\PhilHealth\SoapService;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;
use Spatie\ArrayToXml\ArrayToXml;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class EclaimsUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $columns = ['last_name', 'first_name', 'middle_name'];
        $query = QueryBuilder::for(EclaimsUpload::class)
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            })
            ->when(isset($request->program_desc), function ($q) use ($request) {
                $q->where('program_desc', $request->program_desc);
            })
            ->when(isset($request->pStatus), function ($q) use ($request) {
                $q->where('pStatus', $request->pStatus);
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
            ->with(['patient', 'caserate.attendant', 'caserate'])
            ->defaultSort('-created_at')
            ->allowedSorts('created_at');

        if ($perPage === 'all') {
            return EclaimsUploadResource::collection($query->get());
        }

        return EclaimsUploadResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = EclaimsUpload::updateOrCreate(
            [
                'pHospitalTransmittalNo' => $request->pHospitalTransmittalNo,
            ],
            $request->only([
                'pTransmissionControlNumber',
                'pReceiptTicketNumber',
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EclaimsUpload $eclaimsUpload)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createRequiredXml(EclaimsUploadRequest $request)
    {
        $message = '';

        $documents = EclaimsUploadDocument::where('pHospitalTransmittalNo', $request->pHospitalTransmittalNo)
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

    public function createEncXml(EclaimsUploadRequest $request)
    {
        $message = '';

        $documents = EclaimsUploadDocument::where('pHospitalTransmittalNo', $request->pHospitalTransmittalNo)
                    ->where('required', 'N')
                    ->get();

        if ($documents) {
            $service = new SoapService();
            $creds = PhilhealthCredential::where('facility_code', auth()->user()->facility_code)
                ->where('program_code', ($request->program_desc == 'cc' || $request->program_desc == 'fp' ? 'mc' : $request->program_desc))
                ->first();

            $eClaimsXMLDocs = '';
            foreach ($documents as $key => $value) {
                $eClaimsXMLDocs .= "
                <DOCUMENT
                    pDocumentType='".$value['doc_type_code']."'
                    pDocumentURL='".$value['doc_url']."'/>";
            }

            $path = 'Eclaims/'.auth()->user()->facility_code.'/'.$request->pHospitalTransmittalNo.'/'.$request->pHospitalTransmittalNo.'.xml';
            $file = Storage::disk('spaces')->get($path);

            $xml = new DOMDocument($file);
            $xml->loadXML($file);
            $fragment = $xml->createDocumentFragment();
            $fragment->appendXML($eClaimsXMLDocs);

            $xml->getElementsByTagName('DOCUMENTS')->item(0)->appendChild($fragment);
            $result = '';
            foreach ($xml->childNodes as $node) {
                $result .= $xml->saveXML($node)."\n";
            }

            $encryptedXml = $service->encryptData($result, $creds->cipher_key);
            Storage::disk('spaces')->put($path.'.enc', $encryptedXml, ['visibility' => 'public', 'ContentType' => 'application/octet-stream']);

            $message = 'Created Successfully!';
        } else {
            $message = 'No Document Found!';
        }

        return response()->json([
            'message' => $message,
            'xml' => $encryptedXml,
        ], 201);
    }
}
