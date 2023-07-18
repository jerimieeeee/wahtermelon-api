<?php

namespace App\Http\Controllers\API\V1\Eclaims;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Eclaims\EclaimsCaserateListRequest;
use App\Http\Resources\API\V1\Eclaims\EclaimsCaserateListResource;
use App\Models\V1\Eclaims\EclaimsCaserateList;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient Eclaims
 *
 * APIs for managing Patient Eclaims
 *
 * @subgroup Patient Eclaims Caserate
 *
 * @subgroupDescription Patient Eclaims Caserate Management.
 */
class EclaimsCaserateListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id string Patient to view
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Eclaims\EclaimsCaserateListResource
     *
     * @apiResourceModel App\Models\V1\Eclaims\EclaimsCaserateList
     */
    public function index(Request $request)//: ResourceCollection
    {
        $query = EclaimsCaserateList::query()
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            })
            ->when(isset($request->program_id) && isset($request->program_desc), function ($query) use ($request) {
                return $query->whereProgramId($request->program_id)
                    ->whereProgramDesc($request->program_desc);
            })
            ->when(isset($request->eclaims_id_arr), function ($query) use ($request) {
                $arrayData = explode(',', $request->eclaims_id_arr);
                return $query->whereNotIn('id', $arrayData);
            })
            ->with('caserateAttendant');

        $eclaimsCaserate = QueryBuilder::for($query);

        return EclaimsCaserateListResource::collection($eclaimsCaserate->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EclaimsCaserateListRequest $request)
    {
        $data = EclaimsCaserateList::updateOrCreate(['id' => $request->id], $request->validated());

        return response()->json(['data' => $data, 'status' => 'Successfully saved'], 201);
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
