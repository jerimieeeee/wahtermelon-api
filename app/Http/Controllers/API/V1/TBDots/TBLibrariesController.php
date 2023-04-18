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
 * @subgroup Libraries for tb case findings.
 *
 * @subgroupDescription List of Libraries for tb case findings.
 */
class TBLibrariesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tb_patient_sources = DB::table('lib_tb_patient_sources')->get();
        $tb_pes = DB::table('lib_tb_pes')->get();
        $tb_pe_answers = DB::table('lib_tb_pe_answers')->get();
        $tb_previous_tb_treatments = DB::table('lib_tb_previous_tb_treatments')->get();
        $tb_reg_groups = DB::table('lib_tb_reg_groups')->get();
        $tb_risk_factors = DB::table('lib_tb_risk_factors')->get();
        $tb_symptoms = DB::table('lib_tb_symptoms')->get();
        $tb_treatment_outcomes = DB::table('lib_tb_treatment_outcomes')->get();
        $tb_answers_yn = DB::table('lib_answer_yn')->get();

        return [
            'tb_patient_sources' => $tb_patient_sources,
            'tb_pes' => $tb_pes,
            'tb_pe_answers' => $tb_pe_answers,
            'tb_previous_tb_treatments' => $tb_previous_tb_treatments,
            'tb_reg_groups' => $tb_reg_groups,
            'tb_risk_factors' => $tb_risk_factors,
            'tb_symptoms' => $tb_symptoms,
            'tb_treatment_outcomes' => $tb_treatment_outcomes,
            'tb_answers_yn' => $tb_answers_yn,
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
