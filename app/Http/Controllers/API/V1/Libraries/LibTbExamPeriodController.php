<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibTbExamPeriodResource;
use App\Models\V1\Libraries\LibTbExamPeriod;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group libraries for TB
 *
 * APIs for managing libraries
 *
 * @subgroup Exam Period.
 *
 * @subgroupDescription List of Exam Periods.
 */
class LibTbExamPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibTbExamPeriodResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibTbExamPeriod
     */
    public function index()
    {
        $query = QueryBuilder::for(LibTbExamPeriod::class);

        return LibTbExamPeriodResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
