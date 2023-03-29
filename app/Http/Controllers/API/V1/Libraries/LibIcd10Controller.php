<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibIcd10Resource;
use App\Models\V1\Libraries\LibIcd10;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Consultation
 *
 * APIs for managing libraries
 *
 * @subgroup ICD10s
 *
 * @subgroupDescription List of ICD10s.
 */
class LibIcd10Controller extends Controller
{
    /**
     * Display a listing of the Icd10s resource.
     *
     * @queryParam filter[search] string Filter by icd10_desc. Example: Cholera
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibIcd10Resource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibIcd10
     *
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $columns = ['icd10_desc'];
        $icd10 = QueryBuilder::for(LibIcd10::class)
            ->when(isset($request->filter['search']), function ($q) use ($request, $columns) {
                $q->search($request->filter['search'], $columns);
            });

        return LibIcd10Resource::collection($icd10->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified ICD10s resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibIcd10Resource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibIcd10
     *
     * @return LibIcd10Resource
     */
    public function show(LibIcd10 $icd10_code, string $id): JsonResource
    {
        return new LibIcd10Resource($icd10_code->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
