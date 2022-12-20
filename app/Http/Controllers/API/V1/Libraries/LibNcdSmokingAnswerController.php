<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdSmokingAnswerResource;
use App\Models\V1\Libraries\LibNcdSmokingAnswer;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 * @subgroup Smoking Answer
 * @subgroupDescription List of Smoking Answers.
 */
class LibNcdSmokingAnswerController extends Controller
{
    /**
     * Display a listing of the Risk Stratification resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdSmokingAnswerResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdSmokingAnswer
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdSmokingAnswer::class);
        return LibNcdSmokingAnswerResource::collection($query->get());
    }
    /**
     * Display the specified Risk Stratification Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdSmokingAnswerResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdSmokingAnswer
     * @param LibNcdSmokingAnswer $smokingAnswer
     * @return LibNcdSmokingAnswerResource
     */
    public function show(LibNcdSmokingAnswer $smokingAnswer): LibNcdSmokingAnswerResource
    {
        $query = LibNcdSmokingAnswer::where('id', $smokingAnswer->id);
        $smokingAnswer = QueryBuilder::for($query)
            ->first();
        return new LibNcdSmokingAnswerResource($smokingAnswer);
    }
}
