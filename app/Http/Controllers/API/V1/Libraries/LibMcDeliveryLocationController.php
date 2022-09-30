<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMcDeliveryLocationResource;
use App\Models\V1\Libraries\LibMcDeliveryLocation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Maternal Care
 *
 * APIs for managing libraries
 * @subgroup Delivery Location
 * @subgroupDescription List of delivery locations.
 */
class LibMcDeliveryLocationController extends Controller
{
    /**
     * Display a listing of the Delivery Location resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMcDeliveryLocationResource
     * @apiResourceModel App\Models\V1\Libraries\LibMcDeliveryLocation
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMcDeliveryLocation::class);
        return LibMcDeliveryLocationResource::collection($query->get());
    }

    /**
     * Display the specified Delivery Location resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMcDeliveryLocationResource
     * @apiResourceModel App\Models\V1\Libraries\LibMcDeliveryLocation
     * @param LibMcDeliveryLocation $deliveryLocation
     * @return LibMcDeliveryLocationResource
     */
    public function show(LibMcDeliveryLocation $deliveryLocation): LibMcDeliveryLocationResource
    {
        $query = LibMcDeliveryLocation::where('code', $deliveryLocation->code);
        $deliveryLocation = QueryBuilder::for($query)
            ->first();
        return new LibMcDeliveryLocationResource($deliveryLocation);
    }
}
