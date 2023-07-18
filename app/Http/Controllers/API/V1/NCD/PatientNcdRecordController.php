<?php

namespace App\Http\Controllers\API\V1\NCD;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\NCD\PatientNcdRecordRequest;
use App\Http\Resources\API\V1\NCD\PatientNcdRecordResource;
use App\Models\V1\NCD\PatientNcdRecord;
use App\Models\V1\NCD\PatientNcdRecordCounselling;
use App\Models\V1\NCD\PatientNcdRecordDiagnosis;
use App\Models\V1\NCD\PatientNcdRecordTargetOrgan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Non-Communicable Disease Management
 *
 * APIs for managing Non-Communicable Disease information
 *
 * @subgroup Patient NCD Record
 *
 * @subgroupDescription Patient NCD Record management.
 */
class PatientNcdRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam consult_ncd_risk_id string Patient record to view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $patientNcdRecord = QueryBuilder::for(PatientNcdRecord::class)
            ->when(isset($request->patient_ncd_id), function ($q) use ($request) {
                $q->where('patient_ncd_id', $request->patient_ncd_id);
            })
            ->when(isset($request->consult_ncd_risk_id), function ($q) use ($request) {
                $q->where('consult_ncd_risk_id', '=', $request->consult_ncd_risk_id);
            })
            ->when(isset($request->patient_id), function ($q) use ($request) {
                $q->where('patient_id', '=', $request->patient_id);
            })
            ->when(isset($request->id), function ($q) use ($request) {
                $q->where('id', '=', $request->id);
            })
            ->with('ncdRecordDiagnosis', 'ncdRecordTargetOrgan', 'ncdRecordCounselling')
            ->defaultSort('consultation_date')
            ->allowedSorts('consultation_date');

        if ($perPage === 'all') {
            return PatientNcdRecordResource::collection($patientNcdRecord->get());
        }

        return PatientNcdRecordResource::collection($patientNcdRecord->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(PatientNcdRecordRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = PatientNcdRecord::updateOrCreate($request->validated());

            $diagnosis_code = $request->diagnosis_code;
            $target_organ_code = $request->target_organ_code;
            $counselling_code = $request->counselling_code;

            PatientNcdRecordDiagnosis::query()
                ->where('consult_ncd_risk_id', $request->safe()->consult_ncd_risk_id)
                ->delete();

            PatientNcdRecordTargetOrgan::query()
                ->where('consult_ncd_risk_id', $request->safe()->consult_ncd_risk_id)
                ->delete();

            PatientNcdRecordCounselling::query()
                ->where('consult_ncd_risk_id', $request->safe()->consult_ncd_risk_id)
                ->delete();

            if (isset($request->diagnosis_code)) {
                foreach ($diagnosis_code as $value) {
                    PatientNcdRecordDiagnosis::where('patient_ncd_record_id', $data->id)->updateOrCreate(['patient_ncd_record_id' => $data->id, 'consult_ncd_risk_id' => $request->consult_ncd_risk_id, 'diagnosis_code' => $value]);
                }
            }

            if (isset($request->target_organ_code)) {
                foreach ($target_organ_code as $value) {
                    PatientNcdRecordTargetOrgan::where('patient_ncd_record_id', $data->id)->updateOrCreate(['patient_ncd_record_id' => $data->id, 'consult_ncd_risk_id' => $request->consult_ncd_risk_id, 'target_organ_code' => $value]);
                }
            }

            if (isset($request->counselling_code)) {
                foreach ($counselling_code as $value) {
                    PatientNcdRecordCounselling::where('patient_ncd_record_id', $data->id)->updateOrCreate(['patient_ncd_record_id' => $data->id, 'consult_ncd_risk_id' => $request->consult_ncd_risk_id, 'counselling_code' => $value]);
                }
            }

            return response()->json([
                'message' => 'Successfully Saved',
            ], 201);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
