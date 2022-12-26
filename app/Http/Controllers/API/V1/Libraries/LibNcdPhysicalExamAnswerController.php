<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdPhysicalExamAnswerResource;
use App\Models\V1\Libraries\LibNcdPhysicalExamAnswer;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 * @subgroup Physical Exam Answer
 * @subgroupDescription List of Physical Exam Answers.
 */
class LibNcdPhysicalExamAnswerController extends Controller
{
    /**
     * Display a listing of the Physical Exam Answer resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdPhysicalExamAnswerResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdPhysicalExamAnswer
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdPhysicalExamAnswer::class);
        return LibNcdPhysicalExamAnswerResource::collection($query->get());
    }
    /**
     * Display the specified Physical Exam Answer Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdPhysicalExamAnswerResource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdPhysicalExamAnswer
     * @param LibNcdPhysicalExamAnswer $physicalExamAnswer
     * @return LibNcdPhysicalExamAnswerResource
     */
    public function show(LibNcdPhysicalExamAnswer $physicalExamAnswer): LibNcdPhysicalExamAnswerResource
    {
        $query = LibNcdPhysicalExamAnswer::where('id', $physicalExamAnswer->id);
        $physicalExamAnswer = QueryBuilder::for($query)
            ->first();
        return new LibNcdPhysicalExamAnswerResource($physicalExamAnswer);
    }
}
