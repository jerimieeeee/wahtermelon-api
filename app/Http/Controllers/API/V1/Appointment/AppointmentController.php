<?php

namespace App\Http\Controllers\API\V1\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Appointment\AppointmentRequest;
use App\Http\Resources\API\V1\Appointment\AppointmentResource;
use App\Models\V1\Appointment\Appointment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

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
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort appointment_date. Add hyphen (-) to descend the list: e.g. appointment_date. Example: -appointment_date
     * @queryParam patient_id string Patient to view.
     * @queryParam year date Year to view.
     * @queryParam month date Month to view.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Appointment\AppointmentResource
     *
     * @apiResourceModel App\Models\V1\Appointment\Appointment paginate=15
     */
    public function index(Request $request)
    {
        $today = now();

        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = Appointment::query()
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
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
            ->when(! isset($request->year) && ! isset($request->month) && ! isset($request->patient_id) && ! isset($request->date), function ($query) use ($today) {
                return $query->whereDate('appointment_date', $today->toDateString());
            });

        $appointment = QueryBuilder::for($query)
            ->with(['appointment'])
            ->defaultSort('appointment_date')
            ->allowedSorts([
                'patient_id',
                'appointment_date' => function ($query, $direction) {
                    $query->orderBy('appointment_date', $direction)->orderBy('appointment_date', 'ASC');
                },
            ]);

        if ($perPage == 'all') {
            return AppointmentResource::collection($appointment->get());
        }

        $appointments = $appointment->paginate($perPage)->withQueryString();

        return AppointmentResource::collection($appointments);

//        $today = now();
//        $month = $request->month ?? $today->month;
//        $year = $request->year ?? $today->year;
//
//        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
//        $query = Appointment::query()
//            ->when(isset($request->patient_id), function ($query) use ($request) {
//                return $query->wherePatientId($request->patient_id);
//            })
//            ->when($year, function ($query) use ($year) {
//                return $query->whereYear('appointment_date', $year);
//            })
//            ->when($month, function ($query) use ($month) {
//                return $query->whereMonth('appointment_date', $month);
//            });
//
//        $appointments = $query->get()->groupBy('appointment_date');
//
//        $currentPage = LengthAwarePaginator::resolveCurrentPage();
//        $items = $appointments->forPage($currentPage, $perPage);
//        $paginator = new LengthAwarePaginator($items, $appointments->count(), $perPage, $currentPage);
//
//        return AppointmentResource::collection($paginator->withQueryString());
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
            Appointment::create(['patient_id' => $request->patient_id, 'appointment_code' => $value['appointment_code'], 'appointment_date' => $request->appointment_date],
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
