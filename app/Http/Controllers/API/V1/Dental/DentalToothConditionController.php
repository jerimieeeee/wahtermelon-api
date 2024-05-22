<?php

namespace App\Http\Controllers\API\V1\Dental;

use App\Http\Requests\API\V1\Dental\DentalToothConditionRequest;
use App\Http\Resources\API\V1\Dental\DentalToothConditionResource;
use App\Models\V1\Dental\DentalToothCondition;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DentalToothConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = DentalToothCondition::query()
                ->when(isset($request->patient_id), function ($q) use ($request) {
                    return $q->wherePatientId($request->patient_id);
                });

        $dentalToothCondition = QueryBuilder::for($query);

        return DentalToothConditionResource::collection($dentalToothCondition->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DentalToothConditionRequest $request)
    {
        $conditions = $request->input('tooth_arr');
        foreach ($conditions as $value) {
            DentalToothCondition::updateOrCreate(['patient_id' => $request->patient_id, 'tooth_number' => $value['tooth_number'], 'consult_id' => $request->consult_id],
                ['patient_id' => $request->input('patient_id'), 'consult_id' => $request->input('consult_id')] + $value);
        }

        return response()->json(['status' => 'Successfully saved'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
