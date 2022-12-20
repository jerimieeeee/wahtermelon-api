<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMedicinePreparationResource;
use App\Models\V1\Libraries\LibMedicinePreparation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Medicine
 *
 * APIs for managing libraries
 * @subgroup Preparations
 * @subgroupDescription List of preparations.
 */
class LibMedicinePreparationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMedicinePreparationResource
     * @apiResourceModel App\Models\V1\Libraries\LibMedicinePreparation
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMedicinePreparation::class);
        return LibMedicinePreparationResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMedicinePreparationResource
     * @apiResourceModel App\Models\V1\Libraries\LibMedicinePreparation
     * @param LibMedicinePreparation $preparation
     * @return LibMedicinePreparationResource
     */
    public function show(LibMedicinePreparation $preparation): LibMedicinePreparationResource
    {
        $query = LibMedicinePreparation::where('code', $preparation->code);
        $preparation = QueryBuilder::for($query)
            ->first();
        return new LibMedicinePreparationResource($preparation);
    }

}
