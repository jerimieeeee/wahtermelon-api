<?php

namespace App\Http\Controllers\API\V1\Eclaims;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Eclaims\EclaimsUploadResource;
use App\Models\V1\Eclaims\EclaimsUpload;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

class EclaimsUploadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(EclaimsUpload::class)
        ->when(isset($request->patient_id), function ($q) use ($request) {
            $q->where('patient_id', $request->patient_id);
        })
        ->when(isset($request->program_desc), function ($q) use ($request) {
          $q->where('program_desc', $request->program_desc);
        })
        ->with('caserate')
        ->defaultSort('-created_at')
        ->allowedSorts('created_at');

        if($perPage === 'all') {
            return EclaimsUploadResource::collection($query->get());
        }

        return EclaimsUploadResource::collection($query->paginate($perPage)->withQueryString());
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
