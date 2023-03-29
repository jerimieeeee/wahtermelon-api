<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMedicineRouteResource;
use App\Models\V1\Libraries\LibMedicineRoute;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Medicine
 *
 * APIs for managing libraries
 *
 * @subgroup Medicine Route
 *
 * @subgroupDescription List of medicine route.
 */
class LibMedicineRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMedicineRouteResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMedicineRoute
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMedicineRoute::class)->orderBy('code');

        return LibMedicineRouteResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMedicineRouteResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMedicineRoute
     */
    public function show(LibMedicineRoute $medicineRoute): LibMedicineRouteResource
    {
        $query = LibMedicineRoute::where('code', $medicineRoute->code);
        $medicineRoute = QueryBuilder::for($query)
            ->first();

        return new LibMedicineRouteResource($medicineRoute);
    }
}
