<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMedicineDurationFrequencyResource;
use App\Models\V1\Libraries\LibMedicineDurationFrequency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Medicine
 *
 * APIs for managing libraries
 * @subgroup Duration Frequencies
 * @subgroupDescription List of duration frequencies.
 */
class LibMedicineDurationFrequencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort the sequence of blood types. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMedicineDurationFrequencyResource
     * @apiResourceModel App\Models\V1\Libraries\LibMedicineDurationFrequency
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMedicineDurationFrequency::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');
        return LibMedicineDurationFrequencyResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMedicineDurationFrequencyResource
     * @apiResourceModel App\Models\V1\Libraries\LibMedicineDurationFrequency
     * @param LibMedicineDurationFrequency $durationFrequency
     * @return LibMedicineDurationFrequencyResource
     */
    public function show(LibMedicineDurationFrequency $durationFrequency): LibMedicineDurationFrequencyResource
    {
        $query = LibMedicineDurationFrequency::where('code', $durationFrequency->code);
        $durationFrequency = QueryBuilder::for($query)
            ->first();
        return new LibMedicineDurationFrequencyResource($durationFrequency);
    }

}
