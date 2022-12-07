<?php

namespace App\Http\Controllers\API\V1\Childcare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Childcare\ConsultCcdevBreastfedRequest;
use App\Http\Resources\API\V1\Childcare\ConsultCcdevBreastfedResource;
use App\Http\Resources\API\V1\Childcare\ConsultCcdevResource;
use App\Models\V1\Childcare\ConsultCcdev;
use App\Models\V1\Childcare\ConsultCcdevBreastfed;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Childcare Breastfed Management
 *
 * APIs for managing Childcare Breastfed information
 * @subgroup Childcare Breastfed
 * @subgroupDescription Childcare Breastfed management.
 */

class ConsultCcdevBreastfedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created Childcare Breastfed resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Childcare\ConsultCcdevBreastfedResource
     * @apiResourceModel App\Models\V1\Childcare\ConsultCcdevBreastfed
     * @param ConsultCcdevBreastfedRequest $request
     * @return JsonResponse
     */
    public function store(ConsultCcdevBreastfedRequest $request)
    {
        $data = ConsultCcdevBreastfed::updateOrCreate(['patient_id' => $request->patient_id],$request->all());
        return response()->json(['data' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Childcare\ConsultCcdevBreastfedResource
     * @apiResourceModel App\Models\V1\Childcare\ConsultCcdevBreastfed
     * @param ConsultCcdevBreastfed $consultccdevbreastfed
     * @return ConsultCcdevBreastfedResource
     */
    public function show(ConsultCcdevBreastfed $patientccdevbfed)
    {
        $query = ConsultCcdevBreastfed::with(['ebfreasons:reason_id,desc'])->where('id', $patientccdevbfed->id);

        $patientccdevbfed = QueryBuilder::for($query)
            ->first();

        return new ConsultCcdevBreastfedResource($patientccdevbfed);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // ConsultCcdevBreastfed::findorfail($id)->update($request->all());
        // return response()->json('Patient Child Care Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
