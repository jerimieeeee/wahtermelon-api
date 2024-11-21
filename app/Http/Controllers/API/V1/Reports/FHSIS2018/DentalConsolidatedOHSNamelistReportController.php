<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\Dental\DentalConsolidatedOHSNamelistService;
use Illuminate\Http\Request;

class DentalConsolidatedOHSNamelistReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, DentalConsolidatedOHSNamelistService $namelistService)
    {
        $data = null;

        //Return Medical, Social, Oral Health Status
        if (in_array($request->params, [
            'allergies',
            'hypertension',
            'diabetes',
            'blood_disorder',
            'heart_disease',
            'thyroid',
            'malignancy_flag',
            'blood_transfusion',
            'tattoo',
            'sweet',
            'alcohol',
            'tobacco',
            'nut',
            'dental_carries',
            'gingivitis',
            'periodontal',
            'debris',
            'calculus',
            'dento_facial'
        ])) {
            // If the condition is true, fetch the data
            $query = $namelistService->get_medical_hx($request);

            $data = $query->get();
        }

        //Return Temporary Tooth (d/f)
        if (in_array($request->params, [
            'temp_decayed',
            'temp_filled',
        ])) {
            // If the condition is true, fetch the data
            $query = $namelistService->get_temporary_tooth_condition($request);

            $data = $query->get();
        }

        //Return Adult Tooth (DMF)
        if (in_array($request->params, [
            'decayed',
            'missing',
            'filled',
        ])) {
            // If the condition is true, fetch the data
            $query = $namelistService->get_adult_tooth_condition($request);

            $data = $query->get();
        }


        //Return Dental Services
        if (in_array($request->params, [
            'op_scaling',
            'permanent_filling',
            'temporary_filling',
            'extraction',
            'gum_treatment',
            'sealant',
            'flouride',
            'post_operative',
            'abscess',
            'other_services',
            'referred',
            'counseling',
            'completed',
        ])) {
            // If the condition is true, fetch the data
            $query = $namelistService->get_dental_services($request);

            $data = $query->get();
        }

        //Return Orally Fit Children
        if (in_array($request->params, [
            'orally_fit',
            'oral_rehab',
        ])) {
            // If the condition is true, fetch the data
            $query = $namelistService->get_dental_ofc($request);

            $data = $query->get();
        }

        return $data; // Return the data

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
}
