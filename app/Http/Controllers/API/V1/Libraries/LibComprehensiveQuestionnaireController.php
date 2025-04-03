<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibComprehensiveQuestionnaireResource;
use App\Models\V1\Libraries\LibComprehensiveQuestionnaire;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class LibComprehensiveQuestionnaireController extends Controller
{
    /**
     * Display a listing of the Comprehensive Questionnaire resource.
     *
     * @queryParam sort string Sort the sequence of Comprehensive Questionnaire. Add hyphen (-) to descend the list: e.g. -sequence. Example: sequence
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibComprehensiveQuestionnaireResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibComprehensiveQuestionnaire
     */
    public function index()
    {
        $query = QueryBuilder::for(LibComprehensiveQuestionnaire::class)
            ->with('comprehensive')
            ->defaultSort('sequence')
            ->allowedSorts('sequence');

        return LibComprehensiveQuestionnaireResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Comprehensive Questionnaire resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibComprehensiveQuestionnaireResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibComprensiveQuestionnaire
     */
    public function show(LibComprehensiveQuestionnaire $comprehensiveQuestionnaire)
    {
        $query = LibComprehensiveQuestionnaire::where('code', $comprehensiveQuestionnaire->code);
        $comprehensiveQuestionnaire = QueryBuilder::for($query)
            ->first();

        return new LibComprehensiveQuestionnaireResource($comprehensiveQuestionnaire);
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
