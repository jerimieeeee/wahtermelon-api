<?php

namespace App\Http\Controllers\API\V1\Barangay;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Barangay\SettingsCatchmentBarangayRequest;
use App\Models\V1\Barangay\SettingsCatchmentBarangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsCatchmentBarangayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingsCatchmentBarangayRequest $request)
    {
        return DB::transaction(function () use ($request){
            SettingsCatchmentBarangay::query()
                ->where('year', $request->safe()->year)
                ->delete();
            $barangay = $request->safe()->barangay;

            foreach ($barangay as $value) {
                SettingsCatchmentBarangay::updateOrCreate(['year' => $request->safe()->year, 'barangay_code' => $value['barangay_code']],
                    $value);
            }

            return response()->json([
                'message' => 'Catchment Barangay Successfully Saved',
            ], 201);
        });

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
