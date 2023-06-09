<?php

namespace App\Http\Controllers\API\V1\GenderBasedViolence;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\GenderBasedViolence\PatientGbvPdfUploadResource;
use App\Models\V1\GenderBasedViolence\PatientGbvPdfUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\QueryBuilder;

class PatientGbvPdfUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = QueryBuilder::for(PatientGbvPdfUpload::class)
            ->allowedFilters(['patient_gbv_id', 'patient_id']);
        return PatientGbvPdfUploadResource::collection($data->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_gbv_id' => 'required|exists:patient_gbvs,id',
            'patient_id' => 'required|exists:patients,id',
            'file' => 'required|mimes:pdf,png,jpg|max:2048',
            'file_title' => 'required',
            'file_desc' => 'required'
        ]);
        $filename = $request->file_title.'.'.$request->file('file')->getClientOriginalExtension();
        $path = $request->file('file')->storeAs('GenderBasedViolence/Files/'.auth()->user()->facility_code, $filename, 'spaces');
        PatientGbvPdfUpload::updateOrCreate($request->except('file') + ['file_url' => $path]);
        //$file = Storage::disk('spaces')->get($path);
        //$type = Storage::disk('spaces')->mimeType($path);

        return response()->json('Photo Successfully Updated');
    }

    /**
     * Display the specified resource.
     */
    public function show(PatientGbvPdfUpload $gbvPdfUpload)
    {
        $fileStorage = Storage::disk('spaces');
        return $fileStorage->download($gbvPdfUpload->file_url);
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
