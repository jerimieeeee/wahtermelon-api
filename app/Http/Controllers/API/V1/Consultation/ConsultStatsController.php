<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @authenticated
 *
 * @group Consultation Information Management
 *
 * APIs for managing Patient Consultation information
 *
 * @subgroup Patient Consultation
 *
 * @subgroupDescription Patient Consultation management.
 */
class ConsultStatsController extends Controller
{
    /**
     * Display Stats of Consultation today.
     *
     * @return array
     */
    public function index()
    {
        $date_today = Carbon::today()->toDateString();

        $today_count = DB::table('consults')
                         ->whereDate('consult_date', '=', $date_today)
                         ->count();

        $pt_count = DB::table('consults')
                         ->select('pt_group as Patient Group', DB::raw('count(*) as count'))
                         ->whereDate('consult_date', '=', $date_today)
                         ->groupBy('pt_group')
                         ->get();

        $patient_count = DB::table('consults')
                        ->whereDate('created_at', '=', $date_today)
                        ->count();

        return ['consult_count' => $today_count,
            'program_count' => $pt_count,
            'patient_registered' => $patient_count, ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
