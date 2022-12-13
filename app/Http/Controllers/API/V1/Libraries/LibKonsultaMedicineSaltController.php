<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineSaltResource;
use App\Models\V1\Libraries\LibKonsultaMedicineSalt;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Konsulta Medicine
 *
 * APIs for managing libraries
 * @subgroup Medicine Salts
 * @subgroupDescription List of medicine salts.
 */
class LibKonsultaMedicineSaltController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineSaltResource
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicineSalt
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibKonsultaMedicineSalt::class);
        return LibKonsultaMedicineSaltResource::collection($query->get());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineSaltResource
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicineSalt
     * @param LibKonsultaMedicineSalt $medicineSalt
     * @return LibKonsultaMedicineSaltResource
     */
    public function show(LibKonsultaMedicineSalt $medicineSalt): LibKonsultaMedicineSaltResource
    {
        $query = LibKonsultaMedicineSalt::where('code', $medicineSalt->code);
        $medicineSalt = QueryBuilder::for($query)
            ->first();
        return new LibKonsultaMedicineSaltResource($medicineSalt);
    }

}
