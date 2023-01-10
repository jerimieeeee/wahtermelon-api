<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibPregnancyDeliveryTypeResource;
use App\Models\V1\Libraries\LibPregnancyDeliveryType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Patient Pregnancy History
 *
 * APIs for managing libraries
 * @subgroup Pregnancy History Delivery Type
 * @subgroupDescription List of Pregnancy History Delivery Types
 */
class LibPregnancyDeliveryTypeController extends Controller
{
    /**
     * Display a listing of the Pregnancy History Delivery Types.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibPregnancyDeliveryTypeResource
     * @apiResourceModel App\Models\V1\Libraries\LibPregnancyDeliveryType
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibPregnancyDeliveryType::class);
        return LibPregnancyDeliveryTypeResource::collection($query->get());
    }

    /**
     * Display the specified Answer Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibPregnancyDeliveryTypeResource
     * @apiResourceModel App\Models\V1\Libraries\LibPregnancyDeliveryType
     * @param LibPatientSocialHistoryAnswer $answer
     * @return LibPatientSocialHistoryAnswerResource
     */
    public function show(LibPregnancyDeliveryType $pregnancyDeliveryType): LibPregnancyDeliveryTypeResource
    {
        $query = LibPregnancyDeliveryType::where('code', $pregnancyDeliveryType->code);
        $pregnancyDeliveryType = QueryBuilder::for($query)
            ->first();
        return new LibPregnancyDeliveryTypeResource($pregnancyDeliveryType);
    }
}
