<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Patient\Patient;
use App\Services\User\StatsService;
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
    public function index(StatsService $statsService)
    {
        /*$date_today = Carbon::today()->toDateString();

        $today_count = Consult::query()
            ->whereDate('consult_date', '=', $date_today)
            ->where('facility_code',auth()->user()->facility_code)
            ->count();

        $pt_count = Consult::query()
            ->select('pt_group as Patient Group', DB::raw('count(*) as count'))
            ->whereDate('consult_date', '=', $date_today)
            ->where('facility_code',auth()->user()->facility_code)
            ->groupBy('pt_group')
            ->get();

        $patient_count = Patient::query()
            ->whereDate('created_at', '=', $date_today)
            ->where('facility_code',auth()->user()->facility_code)
            ->count();

        //Patient Birthday Celebrant
        $patient_birthdate = $statsService->get_patient_birthday_celebrants()
                            ->where('facility_code',auth()->user()->facility_code)
                            ->get();

        //User Birthday Celebrant
        $user_birthdate = $statsService->get_users_birthday_celebrants()
                            ->where('facility_code',auth()->user()->facility_code)
                            ->get();

        return ['consult_count' => $today_count,
            'program_count' => $pt_count,
            'patient_registered' => $patient_count,

            //Patient Birthday Celebrant
            'patient_birthdate' => $patient_birthdate,

            //User Birthday Celebrant
            'user_birthdate' => $user_birthdate,

        ];*/
        return ['consult_count' => 0,
            'program_count' => 0,
            'patient_registered' => 0,

            //Patient Birthday Celebrant
            'patient_birthdate' => [],

            //User Birthday Celebrant
            'user_birthdate' => [],

        ];
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
