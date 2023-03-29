<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMcAttendantResource;
use App\Models\V1\Libraries\LibMcAttendant;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Maternal Care
 *
 * APIs for managing libraries
 *
 * @subgroup Attendant
 *
 * @subgroupDescription List of attendants.
 */
class LibMcAttendantController extends Controller
{
    /**
     * Display a listing of the Attendant resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMcAttendantResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMcAttendant
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMcAttendant::class);

        return LibMcAttendantResource::collection($query->get());
    }

    /**
     * Display the specified Attendant resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMcAttendantResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMcAttendant
     */
    public function show(LibMcAttendant $attendant): LibMcAttendantResource
    {
        $query = LibMcAttendant::where('code', $attendant->code);
        $attendant = QueryBuilder::for($query)
            ->first();

        return new LibMcAttendantResource($attendant);
    }
}
