<?php

namespace App\Http\Controllers\API\V1\Dental;

use App\Http\Requests\API\V1\Dental\DentalMedicalSocialsRequest;
use App\Http\Resources\API\V1\Dental\DentalMedicalSocialsResource;
use App\Models\V1\Dental\DentalMedicalSocials;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DentalMedicalSocialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $data = DentalMedicalSocial::updateOrCreate(['id' => $request->id], $request->validated());

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
