<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Models\V1\Patient\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PatientImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request->id;
        $this->validate($request, [
            'image' => 'required|image|max:2048',
            'id' => 'required|exists:patients,id',
        ]);

        // Generate a unique filename
        $filename = $request->id.'.'.$request->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs('Patient/Images/'.auth()->user()->facility_code, $filename, 'spaces');
        Patient::find($request->id)->update(['image_url' => $path]);
        $file = Storage::disk('spaces')->get($path);
        $type = Storage::disk('spaces')->mimeType($path);

        return response()->json('Photo Successfully Updated');
        // return (new Response($file, 200))->header('Content-Type', $type);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $path = Patient::find($id);
        $file = Storage::disk('spaces')->get($path->image_url);
        $type = Storage::disk('spaces')->mimeType($path->image_url);

        return (new Response($file, 200))->header('Content-Type', $type);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // return $request->input('a');
        $this->validate($request, [
            'image' => 'required|image|max:2048',
        ]);

        // Generate a unique filename
        $filename = uniqid().'.'.$request->file('image')->getClientOriginalExtension();
        $fileName = 'Patient/Images/'.auth()->user()->facility_code.'/'.$filename;
        Storage::disk('spaces')->put($fileName, $request->file('image'));

        return response()->json('Photo Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
