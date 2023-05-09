<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvComplaintRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvComplaintResource;
use App\Models\V1\GenderBasedViolence\PatientGbvComplaint;
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
 * @subgroup Patient GBV Complaint
 *
 * @subgroupDescription Patient GBV Complaint Management.
 */
class PatientGbvComplaintController extends Controller
{
    /**
     * Display a listing of the Patient GBV Complaint resource.
     *
     * @queryParam patient_id string Patient to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvComplaintResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvComplaint
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvComplaint::query()
            ->with(['patientGbv', 'complaint'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvNeglect = QueryBuilder::for($query);

        return PatientGbvComplaintResource::collection($patientGbvNeglect->get());
    }

    /**
     * Store a newly created Patient GBV Complaint resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvComplaintResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvComplaint
     */
    public function store(PatientGbvComplaintRequest $request)
    {
        $data = PatientGbvComplaint::create($request->validated());

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
    public function update(PatientGbvComplaintRequest $request, PatientGbvComplaint $patientGbvComplaint)
    {
        $patientGbvComplaint->update($request->safe()->only('complaint_id', 'complaint_specific'));

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
