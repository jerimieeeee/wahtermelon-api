<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibAppointmentResource;
use App\Models\V1\Libraries\LibAppointment;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Appointments
 *
 * APIs for managing libraries
 *
 * @subgroup Appointments
 *
 * @subgroupDescription List of Appointment types.
 */
class LibAppointmentController extends Controller
{
    /**
     * Display a listing of the Appointment Type resource.
     *
     * @queryParam sort string Sort the sequence of appointment types. Add hyphen (-) to descend the list: e.g. -order_seq. Example: order_seq
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibAppointmentResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibAppointment
     */
    public function index()
    {
        $query = QueryBuilder::for(LibAppointment::class)
            ->defaultSort('order_seq')
            ->allowedSorts('order_seq');

        return LibAppointmentResource::collection($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Appointment Type resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibAppointmentResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibAppointment
     */
    public function show(LibAppointmentResource $appointment)
    {
        $query = LibAppointment::where('code', $appointment->code);
        $appointment = QueryBuilder::for($query)
            ->first();

        return new LibAppointmentResource($appointment);
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
