<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMedicinePurposeResource;
use App\Models\V1\Libraries\LibMedicinePurpose;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Medicine
 *
 * APIs for managing libraries
 *
 * @subgroup Purposes
 *
 * @subgroupDescription List of purposes.
 */
class LibMedicinePurposeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort the sequence of blood types. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMedicinePurposeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMedicinePurpose
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMedicinePurpose::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibMedicinePurposeResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMedicineDurationFrequencyResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMedicineDurationFrequency
     */
    public function show(LibMedicinePurpose $purpose): LibMedicinePurposeResource
    {
        $query = LibMedicinePurpose::where('code', $purpose->code);
        $purpose = QueryBuilder::for($query)
            ->first();

        return new LibMedicinePurposeResource($purpose);
    }
}
