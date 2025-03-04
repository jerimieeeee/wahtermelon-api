<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibAsrhConsentTypeResource;
use App\Models\V1\Libraries\LibAsrhConsentType;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LibAsrhConsentTypeController extends Controller
{
    /**
     * Display a listing of the Consent Type resource.
     *
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibAsrhConsentTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibAsrhConsentType
     */
    public function index()
    {
        $query = QueryBuilder::for(LibAsrhConsentType::class);

        return LibAsrhConsentTypeResource::collection($query->get());
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
     * @apiResource App\Http\Resources\API\V1\Libraries\LibAsrhConsentTypeResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibasrhConsentType
     */
    public function show(LibAsrhConsentType $consentType)
    {
        $query = LibAsrhConsentType::where('id', $consentType->id);
        $consent = QueryBuilder::for($query)
            ->first();

        return new LibAsrhConsentTypeResource($consent);
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
