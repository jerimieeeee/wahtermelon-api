<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineUnitResource;
use App\Models\V1\Libraries\LibKonsultaMedicineUnit;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Konsulta Medicine
 *
 * APIs for managing libraries
 *
 * @subgroup Medicine Units
 *
 * @subgroupDescription List of medicine units.
 */
class LibKonsultaMedicineUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineUnitResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicineUnit
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = QueryBuilder::for(LibKonsultaMedicineUnit::class);

        if ($perPage === 'all') {
            return LibKonsultaMedicineUnitResource::collection($query->get());
        }

        return LibKonsultaMedicineUnitResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineUnitResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicineUnit
     */
    public function show(LibKonsultaMedicineUnit $medicineUnit): LibKonsultaMedicineUnitResource
    {
        $query = LibKonsultaMedicineUnit::where('code', $medicineUnit->code);
        $medicineUnit = QueryBuilder::for($query)
            ->first();

        return new LibKonsultaMedicineUnitResource($medicineUnit);
    }
}
