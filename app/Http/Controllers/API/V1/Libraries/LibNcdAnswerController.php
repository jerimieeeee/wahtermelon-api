<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdAnswerResource;
use App\Models\V1\Libraries\LibNcdAnswer;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 *
 * @subgroup Answer
 *
 * @subgroupDescription List of Answers.
 */
class LibNcdAnswerController extends Controller
{
    /**
     * Display a listing of the Answer resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdAnswerResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibNcdAnswer
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdAnswer::class);

        return LibNcdAnswerResource::collection($query->get());
    }

    /**
     * Display the specified Answer Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdAnswerResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibNcdAnswer
     */
    public function show(LibNcdAnswer $answer): LibNcdAnswerResource
    {
        $query = LibNcdAnswer::where('id', $answer->id);
        $answer = QueryBuilder::for($query)
            ->first();

        return new LibNcdAnswerResource($answer);
    }
}
