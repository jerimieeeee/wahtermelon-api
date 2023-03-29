<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMedicineDoseRegimenResource;
use App\Models\V1\Libraries\LibMedicineDoseRegimen;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Medicine
 *
 * APIs for managing libraries
 *
 * @subgroup Dose Regimens
 *
 * @subgroupDescription List of dose regimens.
 */
class LibMedicineDoseRegimenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort the sequence of blood types. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMedicineDoseRegimenResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMedicineDoseRegimen
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMedicineDoseRegimen::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibMedicineDoseRegimenResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMedicineDoseRegimenResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMedicineDoseRegimen
     */
    public function show(LibMedicineDoseRegimen $doseRegimen): LibMedicineDoseRegimenResource
    {
        $query = LibMedicineDoseRegimen::where('code', $doseRegimen->code);
        $doseRegimen = QueryBuilder::for($query)
            ->first();

        return new LibMedicineDoseRegimenResource($doseRegimen);
    }
}
