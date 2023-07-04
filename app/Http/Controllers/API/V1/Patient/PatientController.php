<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientRequest;
use App\Http\Resources\API\V1\Patient\PatientResource;
use App\Models\V1\Patient\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Personal Information Management
 *
 * APIs for managing patient information
 *
 * @subgroup Patient
 *
 * @subgroupDescription Patient management.
 */
class PatientController extends Controller
{
    /**
     * Display a listing of the Patient resource.
     *
     * @queryParam filter[search] string Filter by last_name, first_name or middle_name. Example: Juwahn Dela Cruz
     * @queryParam include string Relationship to view: e.g. householdMember Example: householdMember
     * @queryParam sort string Sort last_name, first_name, middle_name, birthdate of the patient. Add hyphen (-) to descend the list: e.g. last_name,birthdate. Example: last_name
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Patient\PatientResource
     *
     * @apiResourceModel App\Models\V1\Patient\Patient paginate=15
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $columns = ['last_name', 'first_name', 'middle_name'];
        $patients = QueryBuilder::for(Patient::class)
            ->when(isset($request->filter['search']), function ($q) use ($request, $columns) {
                $q->orSearch($columns, 'LIKE', $request->filter['search']);
            })
            ->allowedIncludes('suffixName', 'pwdType', 'religion', 'householdMember', 'philhealthLatest')
            ->defaultSort('last_name', 'first_name', 'middle_name', 'birthdate')
            ->allowedSorts(['last_name', 'first_name', 'middle_name', 'birthdate']);
        if ($perPage === 'all') {
            return PatientResource::collection($patients->get());
        }

        return PatientResource::collection($patients->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created Patient resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\Patient\PatientResource
     *
     * @apiResourceModel App\Models\V1\Patient\Patient
     */
    public function store(PatientRequest $request): JsonResponse
    {
        $data = Patient::create($request->safe()->except('difficulty_seeing', 'difficulty_hearing', 'difficulty_walking', 'difficulty_remembering', 'difficulty_self_care', 'difficulty_speaking'));
        $data->patientWashington()->create($request->safe()->only('difficulty_seeing', 'difficulty_hearing', 'difficulty_walking', 'difficulty_remembering', 'difficulty_self_care', 'difficulty_speaking'));
        return response()->json(['data' => $data, 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Patient\PatientResource
     *
     * @apiResourceModel App\Models\V1\Patient\Patient
     */
    public function show(Patient $patient): PatientResource
    {
        $query = Patient::where('id', $patient->id);
        $patient = QueryBuilder::for($query)
            ->with('householdFolder.barangay', 'householdMember', 'patientWashington', 'philhealthLatest')
            ->first();

        return new PatientResource($patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        // return $request->all();
        $patient->update($request->safe()->except('difficulty_seeing', 'difficulty_hearing', 'difficulty_walking', 'difficulty_remembering', 'difficulty_self_care', 'difficulty_speaking'));
        $patient->patientWashington()->updateOrCreate(['patient_id' => $patient->id], $request->safe()->only('difficulty_seeing', 'difficulty_hearing', 'difficulty_walking', 'difficulty_remembering', 'difficulty_self_care', 'difficulty_speaking'));

        return response()->json(['data' => $patient, 'status' => 'Update successful!'], 200);
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
