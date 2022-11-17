<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientVaccineRequest;
use App\Http\Requests\API\V1\Patient\PatientVaccineUpdateRequest;
use App\Http\Resources\API\V1\Patient\PatientVaccineResource;
use App\Models\V1\Libraries\LibVaccine;
use App\Models\V1\Patient\PatientVaccine;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Patient Vaccine Management
 *
 * APIs for managing Patient Vaccine information
 * @subgroup Patient Vaccine
 * @subgroupDescription Patient Vaccine management.
 */

class PatientVaccineController extends Controller
{
    /**
     * Display a listing of the Patient Vaccines resource.
     *
     * @queryParam sort string Sort vaccine_id, vaccine_date, of the patient. Example: -vaccine_id
     * @queryParam patient_id string Patient to view.
     * @apiResourceCollection App\Http\Resources\API\V1\Patient\PatientVaccineResource
     * @apiResourceModel App\Models\V1\Patient\PatientVaccine paginate=15
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = PatientVaccine::query()->with(['vaccines:vaccine_id,vaccine_name,vaccine_desc'])
                ->when(isset($request->patient_id), function($query) use($request){
                    return $query->wherePatientId($request->patient_id);
                });
        $vaccines = QueryBuilder::for($query)
                ->defaultSort('-vaccine_date', '-vaccine_id')
                ->allowedSorts(['vaccine_date', 'vaccine_id']);

        if ($perPage == 'all') {
            return PatientVaccineResource::collection($vaccines->get());
        }

        return PatientVaccineResource::collection($vaccines->paginate($perPage));
    }

        // return PatientResource::collection($patients->paginate($perPage));

    /**
     * Store a newly created Patient Vaccine resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Patient\PatientVaccineResource
     * @apiResourceModel App\Models\V1\Patient\PatientVaccine
     * @param PatientVaccineRequest $request
     * @return JsonResponse
     */
    public function store(PatientVaccineRequest $request): JsonResponse
    {
            $vaccine = $request->input('vaccines');
            foreach($vaccine as $value){
                PatientVaccine::updateOrCreate(['patient_id' => $request->patient_id, 'vaccine_id' => $value['vaccine_id'], 'vaccine_date' => $value['vaccine_date']],
                ['patient_id' => $request->input('patient_id'),'user_id' => $request->input('user_id')] + $value);
            }

            $patientvaccines = PatientVaccine::where('patient_id', '=', $request->patient_id)->orderBy('vaccine_date', 'ASC')->get();

            return response()->json([
                'message' => 'Vaccine Successfully Saved',
                'data' => $patientvaccines
            ], 201);
    }

    /**
     * Show the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Patient\PatientVaccineResource
     * @apiResourceModel App\Models\V1\Patient\PatientVaccine
     * @param PatientVaccine $patientvaccine
     * @return PatientVaccineResource
     */
    public function show(PatientVaccine $patientvaccine)
    {
        $query = PatientVaccine::with(['vaccines:vaccine_id,vaccine_name,vaccine_desc'])->where('patient_id', $patientvaccine->patient_id)
        ->orderBy('vaccine_date', 'desc')
        ->get();

        return PatientVaccineResource::collection($query);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientVaccineUpdateRequest $request, $id): JsonResponse
    {
        PatientVaccine::findorfail($id)->update($request->all());
        return response()->json('Vaccine Successfully Updated');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        PatientVaccine::findorfail($id)->forceDelete($request->all());
        return response()->json('Vaccine Successfully Deleted');
    }
}
