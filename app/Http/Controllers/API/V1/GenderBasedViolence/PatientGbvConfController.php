<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvConfRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvConfResource;
use App\Models\V1\GenderBasedViolence\PatientGbvConf;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvConfController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvConf::query()
            ->with('patientGbv')
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvConf = QueryBuilder::for($query);

        return PatientGbvConfResource::collection($patientGbvConf->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientGbvConfRequest $request)
    {
        $data = PatientGbvConf::create($request->validated());

        return response()->json(['data' => $data, 'status' => 'Successfully saved'], 201);
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
    public function update(PatientGbvConfRequest $request, PatientGbvConf $patientGbvConf)
    {
        $patientGbvConf->update($request->safe()->only(['conference_date', 'notes']));

        return response()->json(['status' => 'Update successful!'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
