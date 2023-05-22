<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvConfRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvConfResource;
use App\Models\V1\GenderBasedViolence\PatientGbvConf;
use App\Models\V1\GenderBasedViolence\PatientGbvConfConcern;
use App\Models\V1\GenderBasedViolence\PatientGbvConfInvite;
use App\Models\V1\GenderBasedViolence\PatientGbvConfMitigatingFactor;
use App\Models\V1\GenderBasedViolence\PatientGbvConfRecommendation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
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
    public function store(PatientGbvConfRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $data = PatientGbvConf::updateOrCreate(['id' => $request->id], $request->validated());
            $invites = $request->safe()->invites;
            $concerns = $request->safe()->concerns;
            $mitigations = $request->safe()->mitigations;
            $recommendations = $request->safe()->recommendations;

            foreach ($invites as $value) {
                PatientGbvConfInvite::updateOrCreate(['patient_id' => $request->patient_id, 'conference_id' => $data->id, 'invite_code' => $value['invite_code']],
                    $value);
            }

            foreach ($concerns as $value) {
                PatientGbvConfConcern::updateOrCreate(['patient_id' => $request->patient_id, 'conference_id' => $data->id, 'concern_code' => $value['concern_code']],
                    $value);
            }

            foreach ($mitigations as $value) {
                PatientGbvConfMitigatingFactor::updateOrCreate(['patient_id' => $request->patient_id, 'conference_id' => $data->id, 'factor_code' => $value['factor_code']],
                    $value);
            }

            foreach ($recommendations as $value) {
                PatientGbvConfRecommendation::updateOrCreate(['patient_id' => $request->patient_id, 'conference_id' => $data->id, 'recommend_code' => $value['recommend_code']],
                    $value);
            }

            return response()->json([
                'message' => 'Successfully Saved!'
            ], 201);
        });
        /* $data = PatientGbvConf::create($request->validated());

        return response()->json(['data' => $data, 'status' => 'Successfully saved'], 201); */
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
        $patientGbvConf->update($request->validated());

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
