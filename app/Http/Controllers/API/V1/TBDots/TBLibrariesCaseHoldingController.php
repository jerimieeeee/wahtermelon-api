<?php

namespace App\Http\Controllers\API\V1\TBDots;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @group Patient TB
 *
 * APIs for managing tb patient
 *
 * @subgroup Libraries for tb case holding.
 *
 * @subgroupDescription List of Libraries for tb case holding.
 */
class TBLibrariesCaseHoldingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tb_enroll_as = DB::table('lib_tb_enroll_as')->get();
        $tb_bacteriological_statuses = DB::table('lib_tb_bacteriological_statuses')->get();
        $tb_anatomical_sites = DB::table('lib_tb_anatomical_sites')->get();
        $tb_eptb_sites = DB::table('lib_tb_eptb_sites')->get();
        $tb_answers_yn = DB::table('lib_answer_yn')->get();
        $tb_ipt_types = DB::table('lib_tb_ipt_types')->get();
        $tb_treatment_regimens = DB::table('lib_tb_treatment_regimens')->get();

        return [
            'tb_enroll_as' => $tb_enroll_as,
            'tb_bacteriological_statuses' => $tb_bacteriological_statuses,
            'tb_anatomical_sites' => $tb_anatomical_sites,
            'tb_eptb_sites' => $tb_eptb_sites,
            'tb_answers_yn' => $tb_answers_yn,
            'tb_ipt_types' => $tb_ipt_types,
            'tb_treatment_regimens' => $tb_treatment_regimens,
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
