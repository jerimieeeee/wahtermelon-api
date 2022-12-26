<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdRecordCounsellingResource;
use App\Models\V1\Libraries\LibNcdRecordCounselling;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 * @subgroup Patient NCD Record Counselling
 * @subgroupDescription List of Patient NCD Record Counselling.
 */
class LibNcdRecordCounsellingController extends Controller
{
    /**
     * Display a listing of the NCD Record Counselling resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdRecordCounsellingResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRecordCounselling
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdRecordCounselling::class);
        return LibNcdRecordCounsellingResource::collection($query->get());
    }
    /**
     * Display the specified NCD Record Counselling Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdRecordCounsellingResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdRecordCounselling
     * @param LibNcdRecordCounselling $counselling
     * @return LibNcdRecordCounsellingResource
     */
    public function show(LibNcdRecordCounselling $counselling): LibNcdRecordCounsellingResource
    {
        $query = LibNcdRecordCounselling::where('id', $counselling->id);
        $counselling = QueryBuilder::for($query)
            ->first();
        return new LibNcdRecordCounsellingResource($counselling);
    }
}
