<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibKonsultaMedicinePackageResource;
use App\Models\V1\Libraries\LibKonsultaMedicinePackage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Konsulta Medicine
 *
 * APIs for managing libraries
 *
 * @subgroup Medicine Packages
 *
 * @subgroupDescription List of medicine packages.
 */
class LibKonsultaMedicinePackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibKonsultaMedicinePackageResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicinePackage
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(LibKonsultaMedicinePackage::class);

        if ($perPage === 'all') {
            return LibKonsultaMedicinePackageResource::collection($query->get());
        }

        return LibKonsultaMedicinePackageResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibKonsultaMedicinePackageResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicinePackage
     */
    public function show(LibKonsultaMedicinePackage $medicinePackage): LibKonsultaMedicinePackageResource
    {
        $query = LibKonsultaMedicinePackage::where('code', $medicinePackage->code);
        $medicinePackage = QueryBuilder::for($query)
            ->first();

        return new LibKonsultaMedicinePackageResource($medicinePackage);
    }
}
