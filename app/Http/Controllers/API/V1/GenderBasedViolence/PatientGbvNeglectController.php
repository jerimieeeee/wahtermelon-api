<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvNeglectRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvNeglectResource;
use App\Models\V1\GenderBasedViolence\PatientGbvNeglect;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient GBV Management
 *
 * APIs for managing Patient GBV information
 *
 * @subgroup Patient GBV Neglect
 *
 * @subgroupDescription Patient GBV Neglect Management.
 */
class PatientGbvNeglectController extends Controller
{
    /**
     * Display a listing of the Patient GBV Neglect resource.
     *
     * @queryParam patient_id string Patient to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvNeglectResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvNeglect
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvNeglect::query()
            ->with(['patientGbv', 'neglect'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvNeglect = QueryBuilder::for($query);

        return PatientGbvNeglectResource::collection($patientGbvNeglect->get());
    }

    /**
     * Store a newly created Patient GBV Neglect resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvNeglectResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvNeglect
     */
    public function store(PatientGbvNeglectRequest $request)
    {
        $data = PatientGbvNeglect::create($request->validated());

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
    public function update(PatientGbvNeglectRequest $request, PatientGbvNeglect $patientGbvNeglect)
    {
        $patientGbvNeglect->update($request->safe()->only('neglect_id'));

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
