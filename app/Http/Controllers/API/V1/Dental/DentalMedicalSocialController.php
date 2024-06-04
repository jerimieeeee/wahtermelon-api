<?php

namespace App\Http\Controllers\API\V1\Dental;

use App\Http\Requests\API\V1\Dental\DentalMedicalSocialRequest;
use App\Http\Resources\API\V1\Dental\DentalMedicalSocialResource;
use App\Models\V1\Dental\DentalMedicalSocial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DentalMedicalSocialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $query = DentalMedicalSocial::query()
                ->when(isset($request->patient_id), function ($q) use ($request) {
                    return $q->wherePatientId($request->patient_id);
                });

        $dentalMedicalSocials = QueryBuilder::for($query);

        return DentalMedicalSocialResource::collection($dentalMedicalSocials->get());
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
    public function store(DentalMedicalSocialRequest $request)
    {
        $data = DentalMedicalSocial::updateOrCreate(['patient_id' => $request->patient_id], $request->validated());

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
    public function destroy(string $id)
    {
        //
    }
}
