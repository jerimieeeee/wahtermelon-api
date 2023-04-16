<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibLaboratoryStoolColorResource;
use App\Models\V1\Libraries\LibLaboratoryStoolColor;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Laboratory
 *
 * APIs for managing libraries
 *
 * @subgroup Laboratory Stool Color
 *
 * @subgroupDescription List of Stool Color.
 */
class LibLaboratoryStoolColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibLaboratoryStoolColorResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryStoolColor
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibLaboratoryStoolColor::class);

        return LibLaboratoryStoolColorResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibLaboratoryStoolColorResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibLaboratoryStoolColor
     */
    public function show(LibLaboratoryStoolColor $stoolColor): LibLaboratoryStoolColorResource
    {
        $query = LibLaboratoryStoolColor::where('code', $stoolColor->code);
        $stoolColor = QueryBuilder::for($query)
            ->first();

        return new LibLaboratoryStoolColorResource($stoolColor);
    }
}
