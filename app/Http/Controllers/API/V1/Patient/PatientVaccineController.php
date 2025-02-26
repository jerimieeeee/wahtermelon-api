<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientVaccineRequest;
use App\Http\Requests\API\V1\Patient\PatientVaccineUpdateRequest;
use App\Http\Resources\API\V1\Patient\PatientVaccineResource;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientVaccine;
use App\Services\Patient\PatientVaccineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Patient Vaccine Management
 *
 * APIs for managing Patient Vaccine information
 *
 * @subgroup Patient Vaccine
 *
 * @subgroupDescription Patient Vaccine management.
 */
class PatientVaccineController extends Controller
{
    /**
     * Display a listing of the Patient Vaccines resource.
     *
     * @queryParam sort string Sort vaccine_id, vaccine_date, of the patient. Example: -vaccine_id
     * @queryParam patient_id string Patient to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Patient\PatientVaccineResource
     *
     * @apiResourceModel App\Models\V1\Patient\PatientVaccine paginate=15
     *
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $patientvax = new PatientVaccineService();
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = PatientVaccine::query()->with(['vaccines:vaccine_id,vaccine_name,vaccine_desc'])
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            });

        $vaccines = QueryBuilder::for($query)
            ->defaultSort('-vaccine_date', '-vaccine_id')
            ->allowedSorts(['vaccine_date', 'vaccine_id']);

        if (isset($request->patient_id)) {
            $data = $patientvax->get_fic_cic($request->patient_id)->first();

            return PatientVaccineResource::collection($vaccines->get())
                ->additional(['status' => $data]);
        }

        if ($perPage == 'all') {
            return PatientVaccineResource::collection($vaccines->first());
        }

        return PatientVaccineResource::collection($vaccines->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created Patient Vaccine resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\Patient\PatientVaccineResource
     *
     * @apiResourceModel App\Models\V1\Patient\PatientVaccine
     */
    public function store(PatientVaccineRequest $request): JsonResponse
    {
        DB::transaction(function() use ($request) {

            $patientvax = new PatientVaccineService();

            $vaccine = $request->input('vaccines');

            foreach ($vaccine as $value) {
                PatientVaccine::updateOrCreate(['patient_id' => $request->patient_id, 'vaccine_id' => $value['vaccine_id'], 'vaccine_date' => $value['vaccine_date']],
                    ['patient_id' => $request->input('patient_id'), 'user_id' => $request->input('user_id')] + $value);
            }

            $data = $patientvax->get_fic_cic($request->patient_id)->first();

            if ($data && !is_null($data->immunization_status)) {
                Patient::where('id', $request->patient_id)
                    ->update(['vaccine_status' => $data->immunization_status]);
            }

        });

        $patientvaccines = PatientVaccine::where('patient_id', '=', $request->patient_id)->orderBy('vaccine_date', 'ASC')->get();

        return response()->json([
            'message' => 'Vaccine Successfully Saved',
            'data' => $patientvaccines,
        ], 201);
    }

    /**
     * Show the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Patient\PatientVaccineResource
     *
     * @apiResourceModel App\Models\V1\Patient\PatientVaccine
     *
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
