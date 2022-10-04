<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibVaccineResource;
use App\Models\V1\Libraries\LibVaccine;
use Database\Seeders\LibVaccineSeeder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Vaccines
 *
 * APIs for managing libraries
 * @subgroup Childcare vaccines
 * @subgroupDescription List of Childcare vaccines.
 */

class LibVaccinesController extends Controller
{
    /**
     * Display a listing of the Childcare vaccine resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibVaccineResource
     * @apiResourceModel App\Models\V1\Libraries\LibVaccine
     * @return ResourceCollection
     */
    public function index()
    {
        // $LibLVaccine = LibVaccine::all();
        // return $LibLVaccine;

        return LibVaccineResource::collection(LibVaccine::orderBy('vaccine_id', 'ASC')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Child resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibVaccineResource
     * @apiResourceModel App\Models\V1\Libraries\LibVaccine
     * @param LibVaccine $vaccine_id
     * @return LibVaccineResource
     */
    public function show(LibVaccine $vaccine_id, string $id): JsonResource
    {
        return new LibVaccineResource($vaccine_id->findOrFail($id));


        // $query = LibVaccine::where('code', $vaccine_id->code);
        // $vaccine = QueryBuilder::for($query)
        //     ->first();
        // return new LibVaccineResource($vaccine);


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
        //
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
