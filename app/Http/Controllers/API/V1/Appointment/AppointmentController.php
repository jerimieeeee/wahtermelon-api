<?php

namespace App\Http\Controllers\API\V1\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Appointment\AppointmentRequest;
use App\Models\V1\Appointment\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @authenticated
 *
 * @group Appointment Management
 *
 * APIs for managing appointments
 *
 * @subgroup Appointment
 *
 * @subgroupDescription Appointment.
 */
class AppointmentController extends Controller
{
    public function join_referral()
    {
        return Appointment::selectRaw('facilities.code, facilities.facility_name')
                ->leftJoin('facilities', 'appointments.referral_facility_code', '=', 'facilities.code');
    }
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort appointment_date. Add hyphen (-) to descend the list: e.g. appointment_date. Example: -appointment_date
     * @queryParam year date Year to view.
     * @queryParam month date Month to view.
     * @queryParam patient_id string Patient to view.
     * @queryParam date date Date to view.
     * @queryParam facility_code string Facility Code to view.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Appointment\AppointmentResource
     *
     * @apiResourceModel App\Models\V1\Appointment\Appointment paginate=15
     */
    public function index(Request $request)
    {
        $today = now();

        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $data = Appointment::selectRaw("
                appointments.patient_id,
                CONCAT(patients.last_name, ',', ' ', patients.first_name) AS name,
                appointments.facility_code,
                lib_appointments.desc AS appointment_desc,
                lib_appointments.module AS modules,
                appointment_date,
                facilities.facility_name as facility_name,
                referral_facility.facility_name as referral_facility_name,
                referral_reason
            ")
            ->join('patients', 'appointments.patient_id', '=', 'patients.id')
            ->join('facilities', 'appointments.facility_code', '=', 'facilities.code')
            ->join('lib_appointments', 'appointments.appointment_code', '=', 'lib_appointments.code')
            ->leftJoinSub($this->join_referral(), 'referral_facility', function ($join) {
                $join->on('appointments.referral_facility_code', '=', 'referral_facility.code');
            })
            ->when(isset($request->patient_id), function ($query) use ($request, $today) {
                return $query->wherePatientId($request->patient_id)
                    ->whereDate('appointment_date', '>=', $today->toDateString());
            })
            ->when(isset($request->year), function ($query) use ($request) {
                return $query->whereYear('appointment_date', $request->year);
            })
            ->when(isset($request->month), function ($query) use ($request) {
                return $query->whereMonth('appointment_date', $request->month);
            })
            ->when(isset($request->date), function ($query) use ($request) {
                return $query->whereDate('appointment_date', $request->date);
            })
            ->when(isset($request->facility_code), function ($query) use ($today, $request) {
                return $query->where('appointments.facility_code', $request->facility_code)
                    ->whereDate('appointment_date', $today->toDateString())
                    ->whereNot('appointment_code', 'REF')
                    ->groupBy('patient_id', 'facility_code', 'appointment_desc', 'appointment_date', 'modules');
            })
            ->when(isset($request->referral_facility_code), function ($query) use ($today, $request) {
                return $query->where('appointments.referral_facility_code', $request->referral_facility_code)
                    ->whereDate('appointment_date', '>=', $today->toDateString())
                    ->groupBy('patient_id', 'facility_code', 'appointment_desc', 'appointment_date', 'modules');
            })
            ->when(! isset($request->facility_code), function ($query) {
                return $query->groupBy('patient_id', 'facility_code', 'appointment_desc', 'appointment_date', 'modules');
            })
            ->when(! isset($request->referral_facility_code), function ($query) {
                return $query->groupBy('patient_id', 'facility_code', 'appointment_desc', 'appointment_date', 'modules');
            })
            ->when(! isset($request->year) && ! isset($request->month) && ! isset($request->patient_id) && ! isset($request->date) && ! isset($request->facility_code) && ! isset($request->referral_facility_code), function ($query) use ($today) {
                return $query->whereDate('appointment_date', $today->toDateString());
            });

        if (isset($request->facility_code) || isset($request->referral_facility_code)) {
            $data = $data->get()->groupBy(function ($item) {
                return $item->name;
            });
        } else {
            $data = $data->get()->groupBy(function ($item) {
                return $item->appointment_date->format('Y-m-d');
            });
        }

        if ($perPage === 'all') {
            return response()->json([$data->all()]);
        }

        return response()->json([$data->paginate($perPage)]);
    }

    /**
     * Store a newly created Appointment resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\Appointment\AppointmentResource
     *
     * @apiResourceModel App\Models\V1\Appointment\Appointment
     */
    public function store(AppointmentRequest $request): JsonResponse
    {
        $appointment = $request->input('appointment');

        Appointment::query()
            ->where('patient_id', $request->safe()->patient_id)
            ->whereHas('appointment', function ($q) use ($request) {
                $q->where('appointment_date', $request->appointment_date);
            })->forceDelete();

        foreach ($appointment as $value) {
            Appointment::create(['patient_id' => $request->patient_id, 'appointment_code' => $value['appointment_code'], 'appointment_date' => $request->appointment_date, 'referral_facility_code' => $request->referral_facility_code, 'referral_reason' => $request->referral_reason],
                $value);
        }

        return response()->json([
            'message' => 'Appointment Successfully Saved',
        ], 201);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
