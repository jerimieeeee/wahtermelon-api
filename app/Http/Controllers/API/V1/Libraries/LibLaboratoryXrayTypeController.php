<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryXrayTypeResource;
use App\Models\V1\Libraries\LibLaboratoryXrayType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Xray Types
 *
 * @subgroupDescription List of Xray Types.
 */
class LibLaboratoryXrayTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryXrayTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryXrayType
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryXrayType::class);

        return LibLaboratoryXrayTypeResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryXrayTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryXrayType
     */
    public function show(LibLaboratoryXrayType $libLaboratoryXrayType): LibLaboratoryXrayTypeResource
    {
        $query = LibLaboratoryXrayType::where('code', $libLaboratoryXrayType->code);
        $libLaboratoryXrayType = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryXrayTypeResource($libLaboratoryXrayType);
    }
}
