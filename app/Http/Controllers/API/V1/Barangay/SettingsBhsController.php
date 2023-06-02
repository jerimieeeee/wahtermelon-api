<?php

namespace App\Http\Controllers\API\V1\Barangay;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Barangay\SettingsBhsRequest;
use App\Http\Resources\API\V1\Barangay\SettingsBhsResource;
use App\Models\V1\Barangay\SettingsBhs;
use App\Models\V1\Barangay\SettingsCatchmentBarangay;
use Illuminate\Http\Request;

class SettingsBhsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = SettingsBhs::with('bhsBarangay', 'assignedUser')->get();
        return SettingsBhsResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingsBhsRequest $request)
    {
        $data = SettingsBhs::updateOrCreate($request->safe()->except('barangay'));
        return $data->bhsBarangay()->sync($request->barangay);
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
