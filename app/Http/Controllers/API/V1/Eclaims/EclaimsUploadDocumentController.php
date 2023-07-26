<?php

namespace App\Http\Controllers\API\V1\Eclaims;

use App\Classes\PhilHealthEClaimsEncryptor;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Eclaims\EclaimsUploadDocumentRequest;
use App\Http\Resources\API\V1\Eclaims\EclaimsUploadDocumentResource;
use App\Models\V1\Eclaims\EclaimsUploadDocument;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Services\PhilHealth\SoapService;
use Illuminate\Http\JsonResponse;
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
        if ($request->hasFile('doc')) {
            $creds = PhilhealthCredential::where('facility_code', auth()->user()->facility_code)
                ->where('program_code', $request->program_desc != 'cc' ? $request->program_desc : 'mc')
                ->first();

            $service = new SoapService();

            $file = $request->file('doc');

            $publicKeyFileName = file_get_contents(storage_path('philhealth/pnpki_philhealth_eclaims_auth_cert.pem')); //Storage::get('public/pnpki_philhealth_eclaims_auth_cert.pem');
            $encryptor = new PhilHealthEClaimsEncryptor();
            $encryptor->setPublicKeyFileName($publicKeyFileName);
            $encryptor->setLoggingEnabled(true);
            $encryptor->setPassword1UsingHexStr('');
            $encryptor->setPassword2UsingHexStr('');
            $encryptor->setIVUsingHexStr('');

            $fileName = '';
            $name = '';
            $extension = $file->getClientOriginalExtension();
            if ($request->doc_type_code === 'OTH') {
                $origFileName = $file->getClientOriginalName();
                $name = $request->doc_type_code.'_'.$origFileName.'.'.$extension.'.enc';
            } else {
                $name = $request->doc_type_code.'.'.$extension.'.enc';
            }
            $fileName = 'Eclaims/'.auth()->user()->facility_code.'/'.$request->pHospitalTransmittalNo.'/'.$name;

            $uxFileToEncrypt = $file;
            $uxMimeType = $file->getMimeType();
            $uxSaveFileName = storage_path('philhealth/uploads/').$request->pHospitalTransmittalNo.'-'.$name;

            $encryptor->encryptImageFile($uxFileToEncrypt, $uxMimeType, $uxSaveFileName);

            Storage::disk('spaces')->put($fileName, file_get_contents($uxSaveFileName), ['visibility' => 'public', 'ContentType' => 'application/octet-stream']);
            $url = Storage::disk('spaces')->url($fileName);

            if ($request->doc_type_code === 'OTH') {
                $data = EclaimsUploadDocument::updateOrCreate(['pHospitalTransmittalNo' => $request->pHospitalTransmittalNo, 'doc_url' => $url], ['patient_id' => $request->patient_id, 'doc_url' => $url, 'required' => 'N', 'doc_type_code' => $request->doc_type_code]);
            } else {
                $data = EclaimsUploadDocument::updateOrCreate(['pHospitalTransmittalNo' => $request->pHospitalTransmittalNo, 'doc_type_code' => $request->doc_type_code], ['patient_id' => $request->patient_id, 'doc_url' => $url, 'required' => 'N']);
            }

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
     *
     * @throws Throwable
     */
    public function destroy(EclaimsUploadDocument $eclaimsDoc): JsonResponse
    {
        return $eclaimsDoc->get();
        $eclaimsDoc->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
