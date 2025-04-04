<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibGenderIdentityResource;
use App\Models\V1\Libraries\LibGenderIdentity;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LibGenderIdentityController extends Controller
{
    /**
     * Display a listing of the Gender Identity resource.
     *
     * @queryParam sort string Sort the sequence of Gender Identity. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibGenderIdentityResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibGenderIdentity
     */
    public function index()
    {
        $query = QueryBuilder::for(LibGenderIdentity::class)
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibGenderIdentityResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Rapid Questionnaire resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibGenderIdentityResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibGenderIdentity
     */
    public function show(LibGenderIdentity $genderIdentity)
    {
        $query = LibGenderIdentity::where('code', $genderIdentity->code);
        $gender = QueryBuilder::for($query)
            ->first();

        return new LibGenderIdentityResource($gender);
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
