<?php

namespace App\Http\Controllers\API\V1\PSGC;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\PSGC\BarangayResource;
use App\Models\V1\PSGC\Barangay;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries
 *
 * APIs for managing libraries
 * @subgroup Barangays
 * @subgroupDescription Philippine Standard Geographic Code (PSGC) Libraries for Barangays.
 */
class BarangayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @responseFile 200 responses/barangays.get.json
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $barangays = QueryBuilder::for(Barangay::class);

        if ($perPage === 'all') {
            return BarangayResource::collection($barangays->get());
        }

        return BarangayResource::collection($barangays->paginate($perPage));
    }

    /**
     * Display the specified resource.
     *
     * @urlParam barangay_code string Barangay code. Example: 012801001
     * @responseFile 200 responses/barangay.get.json
     * @param Request $request
     * @param Barangay $barangay
     * @return BarangayResource
     */
    public function show(Request $request, Barangay $barangay): BarangayResource
    {
        $query = Barangay::where('id', $barangay->id);

        $barangay = QueryBuilder::for($query)
            ->first();

        return new BarangayResource($barangay);
    }
}
