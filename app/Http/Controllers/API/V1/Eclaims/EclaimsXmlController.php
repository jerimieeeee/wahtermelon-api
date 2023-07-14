<?php

namespace App\Http\Controllers\API\V1\Eclaims;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Eclaims\EclaimsXmlRequest;
use App\Models\V1\Eclaims\EclaimsUpload;
use App\Services\Eclaims\EclaimsXmlService;
use App\Services\PhilHealth\SoapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EclaimsXmlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Create XML for CF2 Submission
     *
     */
    public function createXml(EclaimsXmlRequest $request, EclaimsXmlService $eclaimsXmlService)
    {
        $eclaimsXml = $eclaimsXmlService->createXml($request->transmittalNumber, $request->patient_id, $request);

        $service = new SoapService();
        $fileName = '';
        $fileName = 'Eclaims/'.auth()->user()->facility_code.'/'.$eclaimsXml['transmittalNumber'].'/'.$eclaimsXml['transmittalNumber'].'.xml';
        // Storage::disk('spaces')->put($fileName, $service->encryptData($eclaimsXml['xml'], $eclaimsXml['cipher_key']), ['visibility' => 'public', 'ContentType' => 'application/octet-stream']);
        // return $eclaimsXml['xml'];
        Storage::disk('spaces')->put($fileName, $eclaimsXml['xml'], ['visibility' => 'public', 'ContentType' => 'application/octet-stream']);

        $data = EclaimsUpload::updateOrCreate(['pHospitalTransmittalNo' => $eclaimsXml['transmittalNumber']],$request->validated());

        return response()->json([
            'message' => 'XML Uploaded Successfully',
            'data' => $data
        ], 201);
    }
}
