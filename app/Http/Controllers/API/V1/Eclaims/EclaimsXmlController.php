<?php

namespace App\Http\Controllers\API\V1\Eclaims;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Eclaims\EclaimsXmlRequest;
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
    public function createXml(Request $request, EclaimsXmlService $eclaimsXmlService)
    {
        return $eclaimsXmlService->createXml($request->patient_id, $request);
    }
}
