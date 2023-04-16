<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMcPresentationResource;
use App\Models\V1\Libraries\LibMcPresentation;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Maternal Care
 *
 * APIs for managing libraries
 *
 * @subgroup Presentation
 *
 * @subgroupDescription List of Presentations.
 */
class LibMcPresentationController extends Controller
{
    /**
     * Display a listing of the Presentation resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMcPresentationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMcPresentation
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMcPresentation::class);

        return LibMcPresentationResource::collection($query->get());
    }

    /**
     * Display the specified Presentation resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMcPresentationResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMcPresentation
     */
    public function show(LibMcPresentation $presentation): LibMcPresentationResource
    {
        $query = LibMcPresentation::where('code', $presentation->code);
        $presentation = QueryBuilder::for($query)
            ->first();

        return new LibMcPresentationResource($presentation);
    }
}
