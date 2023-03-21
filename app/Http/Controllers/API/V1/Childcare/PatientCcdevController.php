<?php

namespace App\Http\Controllers\API\V1\Childcare;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Consultation\ConsultResource;
use App\Models\V1\Consultation\Consult;
use Illuminate\Http\Request;
use App\Models\V1\Childcare\PatientCcdev;
use App\Http\Requests\API\V1\Childcare\PatientCcdevRequest;
use App\Http\Resources\API\V1\Childcare\PatientCcdevResource;
use App\Services\Childcare\PatientChildcareService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Childcare Information Management
 *
 * APIs for managing Childcare Patient information
 * @subgroup Childcare Patient
 * @subgroupDescription Childcare Patient management.
 */
class PatientCcdevController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id Identification code of the patient.
     * @queryParam sort string Sort consult_date. Add hyphen (-) to descend the list: e.g. admission_date. Example: admission_date
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\Childcare\PatientCcdevResource
     * @apiResourceModel App\Models\V1\Childcare\PatientCcdev paginate=15
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PatientChildcareService $ccdevStatus): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $ccdev = QueryBuilder::for(PatientCcdev::class)
            ->when(isset($request->patient_id), function($q) use($request){
                $q->where('patient_id', '=', $request->patient_id);
            })
            ->leftJoinSub($ccdevStatus->get_cpab(), 'patientccdev', function($join) {
                $join->on('patient_ccdevs.mothers_id', '=', 'patientccdev.mothersId');
            })

            ->defaultSort('admission_date')
            ->allowedSorts('admission_date');

        if ($perPage === 'all') {
            return PatientCcdevResource::collection($ccdev->get());
        }

        return PatientCcdevResource::collection($ccdev->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created Patient Childcare resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Childcare\PatientCcdevResource
     * @apiResourceModel App\Models\V1\Childcare\PatientCcdev
     * @param PatientCcdevRequest $request
     * @return JsonResponse
     */
    public function store(PatientCcdevRequest $request)
    {
        $data = PatientCcdev::updateOrCreate(['patient_id' => $request->patient_id],$request->all());
        return response()->json(['data' => $data], 201);
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Childcare\PatientCcdevResource
     * @apiResourceModel App\Models\V1\Childcare\PatientCcdev
     * @param PatientCcdev $patientccdev
     * @return PatientCcdevResource
     */

    public function show(PatientCcdev $patientccdev, PatientChildcareService $ccdevStatus)
    {
        $query = PatientCcdev::where('id', $patientccdev->id)
                ->leftJoinSub($ccdevStatus->get_cpab_status($patientccdev->mothers_id), 'patientccdev', function($join) {
                    $join->on('mothers_id', '=', 'patientccdev.mothersId');
                 });
        $patientccdev = QueryBuilder::for($query)
            ->first();

        return new PatientCcdevResource($patientccdev);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        PatientCcdev::findorfail($id)->update($request->only('nbs_filter'));

        return response()->json([
            'message' => 'Patient Childcare Successfully Saved',
        ], 201);
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
