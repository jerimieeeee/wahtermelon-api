<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdAlcoholIntakeAnswerResource;
use App\Models\V1\Libraries\LibNcdAlcoholIntakeAnswer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 * @subgroup Alcohol Intake
 * @subgroupDescription List of Alcohol Intake Answers.
 */
class LibNcdAlcoholIntakeAnswerController extends Controller
{
    /**
     * Display a listing of the Alcohol Intake Answers resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdAlcoholIntakeAnswerResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdAlcoholIntakeAnswer
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdAlcoholIntakeAnswer::class);
        return LibNcdAlcoholIntakeAnswerResource::collection($query->get());
    }
        /**
     * Display the specified Alcohol Intake Answers Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdAlcoholIntakeAnswerResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdAlcoholIntakeAnswer
     * @param LibNcdAlcoholIntakeAnswer $alcoholIntake
     * @return LibNcdAlcoholIntakeAnswerResource
     */
    public function show(LibNcdAlcoholIntakeAnswer $alcoholIntake): LibNcdAlcoholIntakeAnswerResource
    {
        $query = LibNcdAlcoholIntakeAnswer::where('id', $alcoholIntake->id);
        $alcoholIntake = QueryBuilder::for($query)
            ->first();
        return new LibNcdAlcoholIntakeAnswerResource($alcoholIntake);
    }
}
