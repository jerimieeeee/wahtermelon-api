<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryBiopsyTypeResource;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryRifResultResource;
use App\Models\V1\Libraries\LibLaboratoryBiopsyType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Biopsy Type
 *
 * @subgroupDescription List of Biopsy Type.
 */
class LibLaboratoryBiopsyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryBiopsyTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryBiopsyType
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryBiopsyType::class);

        return LibLaboratoryBiopsyTypeResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryBiopsyTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryBiopsyType
     */
    public function show(LibLaboratoryBiopsyType $libLaboratoryBiopsyType): LibLaboratoryBiopsyTypeResource
    {
        $query = LibLaboratoryBiopsyType::where('code', $libLaboratoryBiopsyType->code);
        $libLaboratoryBiopsyType = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryBiopsyTypeResource($libLaboratoryBiopsyType);
    }
}
