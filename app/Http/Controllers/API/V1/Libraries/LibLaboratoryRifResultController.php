<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryRifResultResource;
use App\Models\V1\Libraries\LibLaboratoryRifResult;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory RIF Result
 *
 * @subgroupDescription List of RIF Results.
 */
class LibLaboratoryRifResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryRifResultResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryRifResult
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryRifResult::class);

        return LibLaboratoryRifResultResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryRifResultResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryRifResult
     */
    public function show(LibLaboratoryRifResult $libLaboratoryRifResult): LibLaboratoryRifResultResource
    {
        $query = LibLaboratoryRifResult::where('code', $libLaboratoryRifResult->code);
        $libLaboratoryRifResult = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryRifResultResource($libLaboratoryRifResult);
    }
}
