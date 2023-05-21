<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvReferralRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvReferralResource;
use App\Models\V1\GenderBasedViolence\PatientGbvReferral;
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
 * @subgroup Patient GBV Referral
 *
 * @subgroupDescription Patient GBV Referral Management.
 */
class PatientGbvReferralController extends Controller
{
    /**
     * Display a listing of the Patient GBV Referral resource.
     *
     * @queryParam patient_id string Patient to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvReferralResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvReferral
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbvReferral::query()
            ->with(['patientGbv', 'referral'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbvReferral = QueryBuilder::for($query);

        return PatientGbvReferralResource::collection($patientGbvReferral->get());
    }

    /**
     * Store a newly created Patient GBV Referral resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvReferralResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbvReferral
     */
    public function store(PatientGbvReferralRequest $request)
    {
        $data = PatientGbvReferral::create($request->validated());

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
    public function update(PatientGbvReferralRequest $request, PatientGbvReferral $patientGbvReferral)
    {
        $patientGbvReferral->update($request->safe()->only(['referral_facility_code', 'referral_date', 'referral_reason', 'service_remarks', 'referral_remarks']));

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
