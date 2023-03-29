<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMedicineUnitOfMeasurementResource;
use App\Models\V1\Libraries\LibMedicineUnitOfMeasurement;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Medicine
 *
 * APIs for managing libraries
 *
 * @subgroup Unit of Measurements
 *
 * @subgroupDescription List of unit of measurements.
 */
class LibMedicineUnitOfMeasurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMedicineUnitOfMeasurementResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMedicineUnitOfMeasurement
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMedicineUnitOfMeasurement::class);

        return LibMedicineUnitOfMeasurementResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMedicineUnitOfMeasurementResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMedicineUnitOfMeasurement
     */
    public function show(LibMedicineUnitOfMeasurement $unitOfMeasurement): LibMedicineUnitOfMeasurementResource
    {
        $query = LibMedicineUnitOfMeasurement::where('code', $unitOfMeasurement->code);
        $unitOfMeasurement = QueryBuilder::for($query)
            ->first();

        return new LibMedicineUnitOfMeasurementResource($unitOfMeasurement);
    }
}
