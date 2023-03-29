<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibPatientSocialHistoryAnswerResource;
use App\Models\V1\Libraries\LibPatientSocialHistoryAnswer;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Patient Social History
 *
 * APIs for managing libraries
 *
 * @subgroup Social History Answers
 *
 * @subgroupDescription List of Social History Answers
 */
class LibPatientSocialHistoryAnswerController extends Controller
{
    /**
     * Display a listing of the Social History Answers.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibPatientSocialHistoryAnswerResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibPatientSocialHistoryAnswer
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibPatientSocialHistoryAnswer::class);

        return LibPatientSocialHistoryAnswerResource::collection($query->get());
    }

    /**
     * Display the specified Answer Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibPatientSocialHistoryAnswerResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibPatientSocialHistoryAnswer
     *
     * @param  LibPatientSocialHistoryAnswer  $answer
     */
    public function show(LibPatientSocialHistoryAnswer $socialHistoryAnswer): LibPatientSocialHistoryAnswerResource
    {
        $query = LibPatientSocialHistoryAnswer::where('id', $socialHistoryAnswer->id);
        $answer = QueryBuilder::for($query)
            ->first();

        return new LibPatientSocialHistoryAnswerResource($answer);
    }
}
