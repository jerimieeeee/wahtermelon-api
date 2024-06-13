<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Consultation\ConsultFeedbackRequest;
use App\Models\V1\Consultation\ConsultFeedback;
use Illuminate\Http\Request;

class ConsultFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(ConsultFeedbackRequest $request)
    {
        $consultExist = ConsultFeedback::where('consult_id', $request->consult_id)->exists();

        if($consultExist) {
            return response()->json(['error' => 'Visit No. already exists.'], 409);
        }

        $data =  ConsultFeedback::create($request->validated());

        return response()->json(['message' => 'Feedback successfully recorded.', 'data' => $data]);
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
