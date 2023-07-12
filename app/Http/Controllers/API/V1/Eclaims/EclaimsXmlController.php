<?php

namespace App\Http\Controllers\API\V1\Eclaims;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Eclaims\EclaimsXmlRequest;
use App\Models\V1\Eclaims\EclaimsUpload;
use App\Services\Eclaims\EclaimsXmlService;
use Illuminate\Http\Request;

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

        // return $request->all();
        $data = EclaimsUpload::updateOrCreate(['pHospitalTransmittalNo' => $eclaimsXml['transmittalNumber']],$request->validated());

        if($data)
        {
            $xml_json = XML2JSON($eclaimsXml['xml']);

        }
        // return ['data' => $eclaimsXml['transmittalNumber']];
        return json_encode($xml_json);
    }
}
