<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibFpPelvicExamResource;
use App\Models\V1\Libraries\LibFpHistory;
use App\Models\V1\Libraries\LibFpPelvicExam;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Family Planning
 *
 * APIs for managing libraries
 *
 * @subgroup Pelvic Exams
 *
 * @subgroupDescription List of Family Planning Pelvic Exams.
 */
class LibFpPelvicExamController extends Controller
{
    /**
     * Display a listing of the Family Planning Pelvic Exams resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibFpPelvicExamResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibFpPelvicExam
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibFpPelvicExam::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibFpPelvicExamResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Family Planning History resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibFpPelvicExamResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibFpPelvicExam
     */
    public function show(LibFpPelvicExam $fpPelvicExam)
    {
        $query = LibFpHistory::where('code', $fpPelvicExam->code);
        $fpPelvicExam = QueryBuilder::for($query)
            ->first();

        return new LibFpPelvicExamResource($fpPelvicExam);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
