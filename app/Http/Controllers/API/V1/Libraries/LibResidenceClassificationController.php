<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibResidenceClassificationResource;
use App\Models\V1\Libraries\LibResidenceClassification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Household
 *
 * APIs for managing libraries
 *
 * @subgroup Residence Classification
 *
 * @subgroupDescription List of residence classification.
 */
class LibResidenceClassificationController extends Controller
{
    /**
     * Display a listing of the Education resource.
     *
     * @queryParam sort string Sort the code of Family role. Add hyphen (-) to descend the list: e.g. -code. Example: code
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibResidenceClassificationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibResidenceClassification
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibResidenceClassification::class)
            ->defaultSort('code')
            ->allowedSorts('code');

        return LibResidenceClassificationResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Family Role resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibResidenceClassificationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibResidenceClassification
     */
    public function show(LibResidenceClassification $residenceClassification): LibResidenceClassificationResource
    {
        $query = LibResidenceClassification::where('code', $residenceClassification->code);
        $residenceClassification = QueryBuilder::for($query)
            ->first();

        return new LibResidenceClassificationResource($residenceClassification);
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
