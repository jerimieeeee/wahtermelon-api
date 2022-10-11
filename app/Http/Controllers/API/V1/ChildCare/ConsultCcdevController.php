<?php

namespace App\Http\Controllers\API\V1\Childcare;

use App\Http\Controllers\Controller;
use App\Models\V1\Childcare\ConsultCcdevs;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\Childcare\ConsultCcdevRequest;

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
     * Store a newly created Consultation Complaints resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Childcare\ConsultCcdevResource
     * @apiResourceModel App\Models\V1\Childcare\ConsultCcdev
     * @param ConsultCcdevRequest $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = ConsultCcdevs::create($request->all());
        return $data;
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
        ConsultCcdevs::findorfail($id)->update($request->all());
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
