<?php

namespace App\Services\Consultation;

use App\Models\V1\Consultation\ConsultFeedback;
use Illuminate\Support\Facades\DB;
use App\Models\V1\Consultation\Consult;

class ConsultFeedbackService
{
    public function get_feedback_score($request)
    {
        return ConsultFeedback::select(
            'score',
            DB::raw('SUM(score_value = 1) AS sad'),
            DB::raw('SUM(score_value = 2) AS neutral'),
            DB::raw('SUM(score_value = 3) AS happy')
        )
        ->fromSub(function ($query) {
            $query->select('consult_id', 'created_at', DB::raw("'Overall' AS score"), 'overall_score AS score_value')
                ->from('consult_feedback')
                ->unionAll(
                    DB::table('consult_feedback')
                        ->select('consult_id', 'created_at', DB::raw("'Cleanliness' AS score"), 'cleanliness_score AS score_value')
                )
                ->unionAll(
                    DB::table('consult_feedback')
                        ->select('consult_id', 'created_at', DB::raw("'Behavior' AS score"), 'behavior_score AS score_value')
                )
                ->unionAll(
                    DB::table('consult_feedback')
                        ->select('consult_id', 'created_at', DB::raw("'Time' AS score"), 'time_score AS score_value')
                )
                ->unionAll(
                    DB::table('consult_feedback')
                        ->select('consult_id', 'created_at', DB::raw("'Quality' AS score"), 'quality_score AS score_value')
                )
                ->unionAll(
                    DB::table('consult_feedback')
                        ->select('consult_id', 'created_at', DB::raw("'Completeness' AS score"), 'completeness_score AS score_value')
                );
        }, 'scores')
        ->join('consults', 'scores.consult_id', '=', 'consults.id')
        ->where('consults.facility_code', auth()->user()->facility_code)
        ->whereDate(DB::raw('DATE(consults.consult_date)'), '=', DB::raw('DATE(consults.created_at)'))
        ->whereBetween(DB::raw('DATE(consults.consult_date)'), [$request->start_date, $request->end_date])
        ->groupBy('score');
    }

    public function get_total_consult($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        COUNT(id) AS total_consult
                    ")
            ->where('consults.facility_code', auth()->user()->facility_code)
            ->whereBetween(DB::raw('DATE(consults.consult_date)'), [$request->start_date, $request->end_date])
            ->get();
        /* return DB::table('consult_feedback')
            ->selectRaw("
                        COUNT(consult_id) AS total_consult
                    ")
            ->join('consults', 'consult_feedback.consult_id', '=', 'consults.id')
            ->where('consults.facility_code', auth()->user()->facility_code)
            ->whereBetween(DB::raw('DATE(consults.consult_date)'), [$request->start_date, $request->end_date])
            ->get(); */
    }

    public function get_back_encoded($request)
    {
        return DB::table('consults')
            ->selectRaw("
                        COUNT(id) AS total_consult
                    ")
            ->where('consults.facility_code', auth()->user()->facility_code)
            ->whereDate(DB::raw('DATE(consults.consult_date)'), '<', DB::raw('DATE(consults.created_at)'))
            ->whereBetween(DB::raw('DATE(consults.consult_date)'), [$request->start_date, $request->end_date])
            ->get();
        /* return DB::table('consult_feedback')
            ->selectRaw("
                        COUNT(consult_id) AS total_consult
                    ")
            ->join('consults', 'consult_feedback.consult_id', '=', 'consults.id')
            ->where('consults.facility_code', auth()->user()->facility_code)
            ->whereDate(DB::raw('DATE(consults.consult_date)'), '<', DB::raw('DATE(consults.created_at)'))
            ->whereBetween(DB::raw('DATE(consults.consult_date)'), [$request->start_date, $request->end_date])
            ->get(); */
    }

    public function get_without_feedback($request)
    {
        return Consult::query()
            ->whereDoesntHave('feedback')
            ->where('consults.facility_code', auth()->user()->facility_code)
            ->whereDate(DB::raw('DATE(consults.consult_date)'), '=', DB::raw('DATE(consults.created_at)'))
            ->whereBetween(DB::raw('DATE(consults.consult_date)'), [$request->start_date, $request->end_date])
            ->count();
    }
}
