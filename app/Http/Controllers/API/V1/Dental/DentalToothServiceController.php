<?php

namespace App\Http\Controllers\API\V1\Dental;

use App\Http\Requests\API\V1\Dental\DentalToothServiceRequest;
use App\Http\Resources\API\V1\Dental\DentalToothServiceResource;
use App\Models\V1\Dental\DentalToothService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DentalToothServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = DentalToothService::query()
                ->when(isset($request->patient_id), function ($q) use ($request) {
                    return $q->wherePatientId($request->patient_id);
                });

        $dentalToothService = QueryBuilder::for($query);

        return DentalToothServiceResource::collection($dentalToothService->get());
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
    public function store(DentalToothServiceRequest $request)
    {
        $data = DentalToothService::updateOrCreate(['consult_id' => $request->consult_id, 'patient_id' => $request->patient_id, 'tooth_number' => $request->tooth_number, 'service_code' => $request->service_code], $request->validated());

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
    public function destroy(DentalToothService $dentalToothService)
    {
        $dentalToothService->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
