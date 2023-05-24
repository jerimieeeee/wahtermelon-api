<?php

namespace App\Http\Controllers\API\V1\Barangay;

use App\Http\Controllers\Controller;
use App\Models\V1\Barangay\SettingsBhs;
use Illuminate\Http\Request;

class SettingsBhsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SettingsBhs::with('bhsBarangay')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = SettingsBhs::updateOrCreate($request->except('barangay'));
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
