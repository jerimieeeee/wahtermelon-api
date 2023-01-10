<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibGeneralSurveyResource;
use App\Models\V1\Libraries\LibGeneralSurvey;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for General Survey
 *
 * APIs for managing libraries
 * @subgroup General Survey
 * @subgroupDescription List of General Surveys.
 */
class LibGeneralSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibGeneralSurveyResource
     * @apiResourceModel App\Models\V1\Libraries\LibGeneralSurvey
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibGeneralSurvey::class);
        return LibGeneralSurveyResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibGeneralSurveyResource
     * @apiResourceModel App\Models\V1\Libraries\LibGeneralSurvey
     * @param LibLaboratoryStoolColor $stoolColor
     * @return LibLaboratoryStoolColorResource
     */
    public function show(LibGeneralSurvey $generalSurvey): LibGeneralSurveyResource
    {
        $query = LibGeneralSurvey::where('code', $generalSurvey->code);
        $generalSurvey = QueryBuilder::for($query)
            ->first();
        return new LibGeneralSurveyResource($generalSurvey);
    }
}
