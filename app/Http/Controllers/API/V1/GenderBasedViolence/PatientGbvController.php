<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\GenderBasedViolence\PatientGbvRequest;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvResource;
use App\Models\V1\GenderBasedViolence\PatientGbv;
use App\Models\V1\GenderBasedViolence\PatientGbvBehavior;
use App\Models\V1\GenderBasedViolence\PatientGbvComplaint;
use App\Models\V1\GenderBasedViolence\PatientGbvNeglect;
use App\Models\V1\GenderBasedViolence\PatientGbvReferral;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient GBV Management
 *
 * APIs for managing Patient GBV information
 *
 * @subgroup Patient GBV
 *
 * @subgroupDescription Patient GBV Management.
 */
class PatientGbvController extends Controller
{
    /**
     * Display a listing of the Patient GBV resource.
     *
     * @queryParam sort string Sort case_date, of the patient gbv. Example: -case_date
     * @queryParam patient_id string Patient to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbv
     */
    public function index(Request $request): ResourceCollection
    {
        $query = PatientGbv::query()
        ->with(['gbvNeglect', 'gbvComplaint', 'gbvBehavior', 'gbvReferral',
                'gbvIntake'])
            /* ->with(['neglect', 'complaints', 'behavior', 'referral', 'interview',
                'interviewPerpetrator', 'interviewSexualAbuses', 'interviewPhysicalAbuses',
                'interviewNeglectAbuses', 'interviewEmotionalAbuses',
                'interviewSummaries', 'interviewDevScreening', 'relation']) */
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });
        $patientGbv = QueryBuilder::for($query)
            ->defaultSort('-gbv_date')
            ->allowedSorts('gbv_date');

        return PatientGbvResource::collection($patientGbv->get());
    }

    /**
     * Store a newly created Patient GBV resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvResource
     *
     * @apiResourceModel App\Models\V1\GenderBasedViolence\PatientGbv
     */
    public function store(PatientGbvRequest $request): JsonResponse
    {
        return DB::transaction(function () use ($request) {
            $data = PatientGbv::updateOrCreate(['id' => $request->id], $request->validated());
            $complaint = $request->safe()->complaint;
            $behavior = $request->safe()->behavior;
            $neglect = $request->safe()->neglect;

            foreach ($complaint as $value) {
                PatientGbvComplaint::updateOrCreate(['patient_id' => $request->patient_id, 'patient_gbv_id' => $data->id, 'complaint_id' => $value['complaint_id']],
                    $value);
            }

            foreach ($behavior as $value) {
                PatientGbvBehavior::updateOrCreate(['patient_id' => $request->patient_id, 'patient_gbv_id' => $data->id, 'behavioral_id' => $value['behavioral_id']],
                    $value);
            }

            foreach ($neglect as $value) {
                PatientGbvNeglect::updateOrCreate(['patient_id' => $request->patient_id, 'patient_gbv_id' => $data->id, 'neglect_id' => $value['neglect_id']],
                    $value);
            }

            if(isset($request->safe()->referral_facility_code)){
                PatientGbvReferral::updateOrCreate(['patient_id' => $request->patient_id, 'patient_gbv_id' => $data->id], $request->validated());
            }

            return response()->json([
                'message' => 'Successfully Saved!'], 201);
        });
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
    public function update(PatientGbvRequest $request, PatientGbv $patientGbv)
    {
        $patientGbv->update($request->validated());

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
