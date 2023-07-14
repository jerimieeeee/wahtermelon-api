<?php

namespace App\Http\Controllers\API\V1\Eclaims;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Eclaims\EclaimsUploadDocumentRequest;
use App\Http\Resources\API\V1\Eclaims\EclaimsUploadDocumentResource;
use App\Models\V1\Eclaims\EclaimsUploadDocument;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Services\PhilHealth\SoapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class EclaimsUploadDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = QueryBuilder::for(EclaimsUploadDocument::class)
                ->where('pHospitalTransmittalNo', $request->pHospitalTransmittalNo);
        /* ->when(isset($request->pHospitalTransmittalNo), function ($q) use ($request) {
            $q->where('pHospitalTransmittalNo', $request->pHospitalTransmittalNo);
        }); */

        return EclaimsUploadDocumentResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EclaimsUploadDocumentRequest $request)
    {
        if($request->hasFile('doc')) {
            $creds = PhilhealthCredential::where('facility_code',auth()->user()->facility_code)
                ->where('program_code', $request->program_desc)
                ->first();

            $service = new SoapService();

            $file = $request->file('doc');

            $fileName = '';
            $fileName = 'Eclaims/'.auth()->user()->facility_code.'/'.$request->pHospitalTransmittalNo.'/'.$request->doc_type_code.'.'.$file->getClientOriginalExtension().'.enc';
            Storage::disk('spaces')->put($fileName, $service->encryptData($file, $creds->cipher_key), ['visibility' => 'public', 'ContentType' => 'application/octet-stream']);
            $url = Storage::disk('spaces')->url($fileName);

            $data = EclaimsUploadDocument::updateOrCreate(['pHospitalTransmittalNo' => $request->pHospitalTransmittalNo, 'doc_type_code' => $request->doc_type_code], ['patient_id' => $request->patient_id, 'doc_url' => $url, 'required' => 'N']);
            return json_encode(['data' => $data, 'mesage' => 'successfully uploaded'], 201);
            // return $url = Storage::disk('spaces')->url($fileName);
        }
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
