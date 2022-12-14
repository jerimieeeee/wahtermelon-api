<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineResource;
use App\Models\V1\Libraries\LibKonsultaMedicine;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Konsulta Medicine
 *
 * APIs for managing libraries
 * @subgroup Medicines
 * @subgroupDescription List of medicines.
 */
class LibKonsultaMedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam filter[code] string Filter by code. Example: 019610000000000SOL3200195AMPUL
     * @queryParam filter[desc] string Filter by desc. Example: VITAMINS
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineResource
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicine
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(LibKonsultaMedicine::class)
            ->allowedFilters(['code', 'desc']);

        if ($perPage === 'all') {
            return LibKonsultaMedicineResource::collection($query->get());
        }

        return LibKonsultaMedicineResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineResource
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicine
     * @param LibKonsultaMedicine $medicine
     * @return LibKonsultaMedicineResource
     */
    public function show(LibKonsultaMedicine $medicine): LibKonsultaMedicineResource
    {
        $query = LibKonsultaMedicine::where('code', $medicine->code);
        $medicine = QueryBuilder::for($query)
            ->first();
        return new LibKonsultaMedicineResource($medicine);
    }

}
