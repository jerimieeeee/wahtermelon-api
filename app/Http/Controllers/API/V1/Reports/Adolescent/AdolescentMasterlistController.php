<?php

namespace App\Http\Controllers\API\V1\Reports\Adolescent;

use App\Http\Controllers\Controller;
use App\Services\Adolescent\AdolescentMasterlistService;
use Illuminate\Http\Request;

class AdolescentMasterlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AdolescentMasterlistService $adolescentMasterlistService)
    {
        $re = $adolescentMasterlistService->get_adolescent_masterlist($request);

        return $re;
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
