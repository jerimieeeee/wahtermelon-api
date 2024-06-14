<?php

namespace App\Http\Controllers\API\V1\Reports\General;

use App\Http\Controllers\Controller;
use App\Services\Consultation\ConsultFeedbackService;
use Illuminate\Http\Request;

class ConsultFeedbackReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ConsultFeedbackService $feedbackService)
    {
        $score = $feedbackService->get_feedback_score($request)->get();
        $total = $feedbackService->get_total_consult($request)->first();
        $back_encode = $feedbackService->get_back_encoded($request)->first();
        $no_feedback = $feedbackService->get_without_feedback($request);
        $with_feedback = $feedbackService->get_with_feedback($request);

        return [
            'score' => $score,
            'total_consult' => $total->total_consult,
            'back_encode' => $back_encode->total_consult,
            'no_feedback' => $no_feedback,
            'with_feedback' => $with_feedback
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
