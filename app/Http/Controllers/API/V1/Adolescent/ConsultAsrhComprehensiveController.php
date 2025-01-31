<?php

namespace App\Http\Controllers\API\V1\Adolescent;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Adolescent\ConsultAsrhComprehensiveRequest;
use App\Http\Resources\API\V1\Adolescent\ConsultAsrhComprehensiveResource;
use App\Models\V1\Adolescent\ConsultAsrhComprehensive;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ConsultAsrhComprehensiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(ConsultAsrhComprehensive::class)
                ->with('consultRapid')
                ->defaultSort('assessment_date')
                ->allowedSorts('assessment_date')
                ->get();
        return ConsultAsrhComprehensiveResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConsultAsrhComprehensiveRequest $request)
    {
        $validatedData = $request->validated();
        $consultAsrhComprehensive = ConsultAsrhComprehensive::updateOrCreate(
            [
                'consult_asrh_rapid_id' => $validatedData['consult_asrh_rapid_id'],
            ],
            $validatedData
        );

        return response()->json([
            'message' => 'Consult ASRH Comprehensive created successfully',
            'data' => $consultAsrhComprehensive
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ConsultAsrhComprehensive $consultAsrhComprehensive)
    {
        $data = QueryBuilder::for(ConsultAsrhComprehensive::class)
                ->with('consultRapid')
                ->where('id', $consultAsrhComprehensive->id)
                ->first();
        return new ConsultAsrhComprehensiveResource($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConsultAsrhComprehensiveRequest $request, ConsultAsrhComprehensive $consultAsrhComprehensive)
    {
        $consultAsrhComprehensive->update($request->validated());

        return response()->json([
            'message' => 'Consult ASRH Comprehensive updated successfully',
            'data' => $consultAsrhComprehensive
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
