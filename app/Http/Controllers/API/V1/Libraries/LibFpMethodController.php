<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibFpMethodResource;
use App\Models\V1\Libraries\LibFpMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @group Libraries for Family Planning
 *
 * APIs for managing libraries
 * @subgroup Family Planning Methods
 * @subgroupDescription List of Family Planning Methods.
 */
class LibFpMethodController extends Controller
{
    /**
     * Display a listing of the Family Planning Methods resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibFpMethodResource
     * @apiResourceModel App\Models\V1\Libraries\LibFpMethod
     * @return ResourceCollection
     */
    public function index()
    {
        return LibFpMethodResource::collection(LibFpMethod::orderBy('report_order', 'ASC')->get());
    }

    /**
     * Display the specified Family Planning Methods resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibFpMethodResource
     * @apiResourceModel App\Models\V1\Libraries\LibFpMethod
     * @param LibFpMethod $method
     * @return LibFpMethodResource
     */
    public function show(LibFpMethod $method, string $id): JsonResource
    {
        return new LibFpMethodResource($method->findOrFail($id));
    }
}
