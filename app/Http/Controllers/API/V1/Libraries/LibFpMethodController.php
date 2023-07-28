<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibFpMethodResource;
use App\Models\V1\Libraries\LibFpMethod;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Family Planning
 *
 * APIs for managing libraries
 *
 * @subgroup Family Planning Methods
 *
 * @subgroupDescription List of Family Planning Methods.
 */
class LibFpMethodController extends Controller
{
    /**
     * Display a listing of the Family Planning Methods resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibFpMethodResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibFpMethod
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibFpMethod::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibFpMethodResource::collection($query->get());
    }

    /**
     * Display the specified Family Planning Methods resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibFpMethodResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibFpMethod
     *
     * @return LibFpMethodResource
     */
    public function show(LibFpMethod $method): ResourceCollection
    {
        $query = LibFpMethod::where('code', $method->code);
        $method = QueryBuilder::for($query)
            ->first();

        return new LibFpMethodResource($method);
    }
}
