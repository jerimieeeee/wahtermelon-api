<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibNcdAnswerS2Resource;
use App\Models\V1\Libraries\LibNcdAnswerS2;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Non-Communicable Disease
 *
 * APIs for managing libraries
 * @subgroup Answer S2
 * @subgroupDescription List of Answers S2.
 */
class LibNcdAnswerS2Controller extends Controller
{
    /**
     * Display a listing of the Answer S2 resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibNcdAnswerS2Resource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdAnswerS2
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibNcdAnswerS2::class);
        return LibNcdAnswerS2Resource::collection($query->get());
    }
    /**
     * Display the specified Answer Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibNcdAnswerS2Resource
     * @apiResourceModel App\Models\V1\Libraries\LibNcdAnswerS2
     * @param LibNcdAnswerS2 $answerS2
     * @return LibNcdAnswerS2Resource
     */
    public function show(LibNcdAnswerS2 $answerS2): LibNcdAnswerS2Resource
    {
        $query = LibNcdAnswerS2::where('id', $answerS2->id);
        $answerS2 = QueryBuilder::for($query)
            ->first();
        return new LibNcdAnswerS2Resource($answerS2);
    }
}
