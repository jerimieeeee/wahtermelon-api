<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibPhilhealthProgramResource;
use App\Models\V1\Libraries\LibPhilhealthProgram;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for PhilHealth Credentials
 *
 * APIs for managing libraries
 * @subgroup PhilHealth Programs
 * @subgroupDescription List of PhilHealth programs.
 */
class LibPhilhealthProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibPhilhealthProgramResource
     * @apiResourceModel App\Models\V1\Libraries\LibPhilhealthProgram
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibPhilhealthProgram::class);
        return LibPhilhealthProgramResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibPhilhealthProgramResource
     * @apiResourceModel App\Models\V1\Libraries\LibPhilhealthProgram
     * @param LibPhilhealthProgram $program
     * @return LibPhilhealthProgramResource
     */
    public function show(LibPhilhealthProgram $program): LibPhilhealthProgramResource
    {
        $query = LibPhilhealthProgram::where('code', $program->code);
        $program = QueryBuilder::for($query)
            ->first();
        return new LibPhilhealthProgramResource($program);
    }

}
