<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryUltrasoundTypeResource;
use App\Models\V1\Libraries\LibLaboratoryUltrasoundType;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Ultrasound Types
 *
 * @subgroupDescription List of Ultrasound Types.
 */
class LibLaboratoryUltrasoundTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryUltrasoundTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryUltrasoundType
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryUltrasoundType::class);

        return LibLaboratoryUltrasoundTypeResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryUltrasoundTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryUltrasoundType
     */
    public function show(LibLaboratoryUltrasoundType $libLaboratoryUltrasoundType): LibLaboratoryUltrasoundTypeResource
    {
        $query = LibLaboratoryUltrasoundType::where('code', $libLaboratoryUltrasoundType->code);
        $libLaboratoryUltrasoundType = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryUltrasoundTypeResource($libLaboratoryUltrasoundType);
    }
}
