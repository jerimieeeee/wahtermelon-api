<?php

namespace App\Http\Controllers\API\V1\Reports\FHSIS2018;

use App\Http\Controllers\Controller;
use App\Services\FamilyPlanning\FamilyPlanningReportService;
use Illuminate\Http\Request;

/**
 * @authenticated
 *
 * @group FHSIS Reports 2018
 *
 * APIs for managing Family Planning Report Information
 *
 * @subgroup M1 Family Planning Report
 *
 * @subgroupDescription M1 Family Planning Report.
 */
class FamilyPlanningReport2018Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam year date to view.
     * @queryParam month date to view.
     */
    public function index(Request $request, FamilyPlanningReportService $familyPlanningReportService)
    {
        $ranges = [
            '10_14' => [10, 14],
            '15_19' => [15, 19],
            '20_49' => [20, 49],
        ];

        $reportData = [];

        foreach (['FSTRBTL', 'MSV', 'CONDOM', 'PILLS', 'PILLSPOP', 'DMPA', 'IMPLANT', 'IUD', 'IUDPP', 'NFPLAM', 'NFPBBT', 'NFPCM', 'NFPSTM', 'NFPSDM'] as $method) {
            foreach (['present', 'previous'] as $period) {
                foreach ($ranges as $key => $range) {
                    $methodName = "{$method}_new_acceptor_{$period}_{$key}";
                    $reportData[$methodName] = $familyPlanningReportService->new_acceptor($request, $method, 'NA', $range[0], $range[1], "NA-{$period}-MONTH")->get();
                }
            }
        }

        foreach (['FSTRBTL', 'MSV', 'CONDOM', 'PILLS', 'PILLSPOP', 'DMPA', 'IMPLANT', 'IUD', 'IUDPP', 'NFPLAM', 'NFPBBT', 'NFPCM', 'NFPSTM', 'NFPSDM'] as $method) {
                foreach ($ranges as $key => $range) {
                    $methodName = "{$method}_other_acceptor_{$key}";
                    $reportData[$methodName] = $familyPlanningReportService->other_acceptor($request, $method, 'NA', $range[0], $range[1])->get();
                }
        }

        foreach (['FSTRBTL', 'MSV', 'CONDOM', 'PILLS', 'PILLSPOP', 'DMPA', 'IMPLANT', 'IUD', 'IUDPP', 'NFPLAM', 'NFPBBT', 'NFPCM', 'NFPSTM', 'NFPSDM'] as $method) {
            foreach ($ranges as $key => $range) {
                $methodName = "{$method}_dropout_{$key}";
                $reportData[$methodName] = $familyPlanningReportService->dropout($request, $method, $range[0], $range[1])->get();
            }
        }

        $newAcceptorData = [];
        $otherAcceptorData = [];
        $dropoutData = [];
//
//        $newAcceptorCount = 0;
//        $otherAcceptorCount = 0;
//        $dropoutCount = 0;


        foreach ($reportData as $methodName => $data) {
            if (strpos($methodName, 'new_acceptor_previous') !== false) {
                $newAcceptorData[$methodName] = $data;
//                $newAcceptorCount += count($data);

            } elseif (strpos($methodName, 'other_acceptor') !== false) {
                $otherAcceptorData[$methodName] = $data;
//                $otherAcceptorCount += count($data);

            } elseif (strpos($methodName, 'dropout') !== false) {
                $dropoutData[$methodName] = $data;
//                $dropoutCount += count($data);
            }
        }

        return [
            'report' => $reportData,
            'current_user_beginning_month' => [
                $newAcceptorData,
                $otherAcceptorData,
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
