<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientPhilhealthRequest;
use App\Http\Resources\API\V1\Patient\PatientPhilhealthResource;
use App\Http\Resources\API\V1\Patient\PatientResource;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientPhilhealth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Philhealth Information Management
 *
 * APIs for managing philhealth information
 * @subgroup Philhealth
 * @subgroupDescription Philhealth management.
 */
class PatientPhilhealthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam search string Filter by member_last_name, member_first_name or member_middle_name. Example: Juwahn Dela Cruz
     * @queryParam filter[philhealth_id] string Filter by philhealth_id. Example: 0123456789123
     * @queryParam filter[patient_id] string Filter by patient_id.
     * @queryParam include string Relationship to view: e.g. patient,user,membershipType,membershipCategory,konsultaRegistration Example: patient,membershipType,membershipCategory,konsultaRegistration
     * @queryParam sort string Sort member_last_name, member_first_name, member_middle_name, member_birthdate of the patient. Add hyphen (-) to descend the list: e.g. member_last_name,member_birthdate. Example: member_last_name
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\Patient\PatientPhilhealthResource
     * @apiResourceModel App\Models\V1\Patient\PatientPhilhealth paginate=15
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $columns = ['last_name', 'first_name', 'middle_name'];
        $patientPhilhealth = QueryBuilder::for(PatientPhilhealth::class)
            ->when(isset($request->search), function($q) use($request, $columns) {
                //$q->search($request->filter['search'], $columns);
                $q->whereHas('patient', function($q) use($request, $columns){
                    $q->search($request->search, $columns);
                });
            })
            ->allowedFilters(['philhealth_id', 'patient_id', 'search'])
            ->allowedIncludes('patient', 'user', 'membershipType', 'membershipCategory', 'konsultaRegistration')
            ->defaultSort('member_last_name', 'member_first_name', 'member_middle_name', 'member_birthdate')
            ->allowedSorts(['member_last_name', 'member_first_name', 'member_middle_name', 'member_birthdate', 'enlistment_date']);
        if ($perPage === 'all') {
            return PatientPhilhealthResource::collection($patientPhilhealth->get());
        }

        return PatientPhilhealthResource::collection($patientPhilhealth->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Patient\PatientPhilhealthResource
     * @apiResourceModel App\Models\V1\Patient\PatientPhilhealth
     * @param PatientPhilhealthRequest $request
     * @return JsonResponse
     */
    public function store(PatientPhilhealthRequest $request): JsonResponse
    {
        $data = PatientPhilhealth::updateOrCreate(['patient_id' => $request->safe()->patient_id, 'effectivity_year' => $request->safe()->effectivity_year], $request->validated());
        return response()->json(['data' => $data, 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Patient\PatientPhilhealthResource
     * @apiResourceModel App\Models\V1\Patient\PatientPhilhealth
     * @param PatientPhilhealth $patientPhilhealth
     * @return PatientPhilhealthResource
     */
    public function show(PatientPhilhealth $patientPhilhealth): PatientPhilhealthResource
    {
        $query = PatientPhilhealth::where('id', $patientPhilhealth->id);
        $patientPhilhealth = QueryBuilder::for($query)
            ->with('patient', 'user')
            ->first();
        return new PatientPhilhealthResource($patientPhilhealth);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PatientPhilhealthRequest  $request
     * @param  PatientPhilhealth $patientPhilhealth
     * @return JsonResponse
     */
    public function update(PatientPhilhealthRequest $request, PatientPhilhealth $patientPhilhealth): JsonResponse
    {
        $patientPhilhealth->update($request->validated());
        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
