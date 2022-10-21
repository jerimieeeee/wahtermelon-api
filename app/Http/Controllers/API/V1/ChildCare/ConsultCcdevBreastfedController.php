<?php

namespace App\Http\Controllers\API\V1\Childcare;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Childcare\ConsultCcdevBreastfedRequest;
use App\Models\V1\Childcare\ConsultCcdevBreastfed;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
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
    public function store(ConsultCcdevBreastfedRequest $request) : JsonResponse
    {
        $data = ConsultCcdevBreastfed::create($request->all());
        return response()->json(['data' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ConsultCcdevBreastfed::where('ccdev_id', '=', $id)->get();
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
        ConsultCcdevBreastfed::findorfail($id)->update($request->all());
        return response()->json('Patient Child Care Successfully Updated');
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
