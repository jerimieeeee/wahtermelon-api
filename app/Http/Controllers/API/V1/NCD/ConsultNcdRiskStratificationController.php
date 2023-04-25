<?php

namespace App\Http\Controllers\API\V1\NCD;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\NCD\ConsultNcdRiskAssessmentResource;
use App\Models\V1\NCD\ConsultNcdRiskAssessment;
use App\Services\NCD\NcdRiskStratificationChartService;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ConsultNcdRiskStratificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id string to view.
     */
    public function index(Request $request)
    {
        //NCD Risk Stratification of Patient
        $ncdRiskStratificationChartService = new NcdRiskStratificationChartService();
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = ConsultNcdRiskAssessment::query()
            ->where('patient_id', $request->patient_id)
            ->with('riskScreeningLipid');

        $riskStrat = QueryBuilder::for($query)
            ->defaultSort('age', '-age')
            ->allowedSorts(['age', 'age']);

        if (! empty($request->patient_id)) {
            $data = $ncdRiskStratificationChartService->getRiskStratificationChart($request);
            if (! empty($data)) {
                return ConsultNcdRiskAssessmentResource::collection($riskStrat->get())
                    ->additional(['risk_stratification' => $data]);
            }
        }

        if ($perPage == 'all') {
            return ConsultNcdRiskAssessmentResource::collection($riskStrat->first());
        }

        return ConsultNcdRiskAssessmentResource::collection($riskStrat->paginate($perPage)->withQueryString());
    }

    public function show()
    {
            //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
