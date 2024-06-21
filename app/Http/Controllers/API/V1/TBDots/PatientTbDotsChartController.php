<?php

namespace App\Http\Controllers\API\V1\TBDots;

use App\Models\V1\TBDots\PatientTbDotsChart;
use App\Http\Requests\API\V1\TBDots\PatientTbDotsChartRequest;
use App\Http\Resources\API\V1\TBDots\PatientTbDotsChartResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PatientTbDotsChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(PatientTbDotsChart::class)
            ->when(isset($request->patient_tb_id), function ($q) use ($request) {
                $q->where('patient_tb_id', $request->patient_tb_id);
            });

        if ($perPage === 'all') {
            return PatientTbDotsChartResource::collection($query->get());
        }

        return PatientTbDotsChartResource::collection($query->paginate($perPage)->withQueryString());
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
    public function store(PatientTbDotsChartRequest $request)
    {
        $dots = $request->input('dots');

        PatientTbDotsChart::query()
            ->where('patient_id', $request->patient_id)
            ->where('patient_tb_id', $request->patient_tb_id)
            ->delete();

        foreach ($dots as $value) {
            PatientTbDotsChart::updateOrCreate(['patient_id' => $request->patient_id, 'patient_tb_id' => $request->patient_tb_id, 'dots_date' => $value['dots_date']],
                ['patient_id' => $request->input('patient_id')] + $value);
        }

        $patientTbDotsChart = PatientTbDotsChart::where('patient_id', '=', $request->patient_id)->orderBy('dots_date', 'ASC')->get();

        return response()->json([
            'message' => 'Vaccine Successfully Saved',
            'data' => $patientTbDotsChart,
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
