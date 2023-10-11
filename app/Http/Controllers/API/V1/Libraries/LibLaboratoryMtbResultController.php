<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryMtbResultResource;
use App\Models\V1\Libraries\LibLaboratoryMtbResult;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory MTB Result
 *
 * @subgroupDescription List of MTB Results.
 */
class LibLaboratoryMtbResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryMtbResultResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryMtbResult
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryMtbResult::class);

        return LibLaboratoryMtbResultResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryMtbResultResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryMtbResult
     */
    public function show(LibLaboratoryMtbResult $libLaboratoryMtbResult): LibLaboratoryMtbResultResource
    {
        $query = LibLaboratoryMtbResult::where('code', $libLaboratoryMtbResult->code);
        $libLaboratoryMtbResult = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryMtbResultResource($libLaboratoryMtbResult);
    }
}
