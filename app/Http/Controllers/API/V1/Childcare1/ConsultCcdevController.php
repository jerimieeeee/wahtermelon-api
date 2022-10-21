<?php

namespace App\Http\Controllers\API\V1\Childcare;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\Childcare\ConsultCcdevRequest;
use App\Models\V1\Childcare\ConsultCcdev;
use Illuminate\Http\JsonResponse;

/**
 * @group Childcare Consultation Management
 *
 * APIs for managing Childcare Consultation information
 * @subgroup Childcare Consultation
 * @subgroupDescription Childcare Consultation management.
 */

class ConsultCcdevController extends Controller
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
     * Store a newly created Childcare Consultation resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Childcare\ConsultCcdevResource
     * @apiResourceModel App\Models\V1\Childcare\ConsultCcdev
     * @param ConsultCcdevRequest $request
     * @return JsonResponse
     */
    public function store(ConsultCcdevRequest $request) : JsonResponse
    {
        $data = ConsultCcdev::create($request->all());
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
        //
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
        ConsultCcdev::findorfail($id)->update($request->all());
        return response()->json('Successfully Updated');
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
