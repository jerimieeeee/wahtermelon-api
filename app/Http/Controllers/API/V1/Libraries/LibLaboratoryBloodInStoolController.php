<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryBloodInStoolResource;
use App\Models\V1\Libraries\LibLaboratoryBloodInStool;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 * @subgroup Laboratory Blood in stool
 * @subgroupDescription List of Blood in stool.
 */
class LibLaboratoryBloodInStoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryBloodInStoolResource
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryBloodInStool
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryBloodInStool::class);
        return LibLaboratoryBloodInStoolResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryFindingsResource
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryFindings
     * @param LibLaboratoryBloodInStool $bloodStool
     * @return LibLaboratoryBloodInStoolResource
     */
    public function show(LibLaboratoryBloodInStool $bloodStool): LibLaboratoryBloodInStoolResource
    {
        $query = LibLaboratoryBloodInStool::where('code', $bloodStool->code);
        $bloodStool = QueryBuilder::for($query)
            ->first();
        return new LibLaboratoryBloodInStoolResource($bloodStool);
    }
}
