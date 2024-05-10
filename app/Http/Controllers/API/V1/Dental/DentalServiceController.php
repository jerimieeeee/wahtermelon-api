<?php

namespace App\Http\Controllers\API\V1\Dental;

use App\Http\Requests\API\V1\Dental\DentalServiceRequest;
use App\Http\Resources\API\V1\Dental\DentalServiceResource;
use App\Models\V1\Dental\DentalService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DentalServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = DentalService::query()
                ->when(isset($request->patient_id), function ($q) use ($request) {
                    return $q->wherePatientId($request->patient_id);
                });

        $dentalService = QueryBuilder::for($query);

        return DentalServiceResource::collection($dentalService->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DentalServiceRequest $request)
    {
        $data = DentalService::updateOrCreate(['consult_id' => $request->consult_id, 'patient_id' => $request->patient_id, 'service_id' => $request->service_id], $request->validated());

        return response()->json(['data' => $data, 'status' => 'Successfully saved'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
    public function destroy(DentalService $dentalService)
    {
        $dentalService->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
