<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMedicineResource;
use App\Models\V1\Libraries\LibMedicine;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Medicine
 *
 * APIs for managing libraries
 *
 * @subgroup Medicines
 *
 * @subgroupDescription List of medicines.
 */
class LibMedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam filter[hprodid] string Filter by hprodid. Example: 03SOD0090PINTR2
     * @queryParam filter[drug_name] string Filter by desc. Example: VITAMINS
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMedicineResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMedicine
     */
    public function index()
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(LibMedicine::class)
            ->allowedFilters(['hprodid', 'drug_name']);

        if ($perPage === 'all') {
            return LibMedicineResource::collection($query->get());
        }

        return LibMedicineResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMedicineResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibMedicine
     */
    public function show(LibMedicine $medicine)
    {
        $query = LibMedicine::where('hprodid', $medicine->hprodid);
        $medicine = QueryBuilder::for($query)
            ->first();

        return new LibMedicineResource($medicine);
    }

}
