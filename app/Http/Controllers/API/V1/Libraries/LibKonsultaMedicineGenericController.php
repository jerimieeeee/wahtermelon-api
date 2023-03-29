<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineGenericResource;
use App\Models\V1\Libraries\LibKonsultaMedicineGeneric;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Konsulta Medicine
 *
 * APIs for managing libraries
 *
 * @subgroup Medicine Generics
 *
 * @subgroupDescription List of medicine generics.
 */
class LibKonsultaMedicineGenericController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineGenericResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicineGeneric
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $query = QueryBuilder::for(LibKonsultaMedicineGeneric::class);

        if ($perPage === 'all') {
            return LibKonsultaMedicineGenericResource::collection($query->get());
        }

        return LibKonsultaMedicineGenericResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineGenericResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicineGeneric
     */
    public function show(LibKonsultaMedicineGeneric $medicineGeneric): LibKonsultaMedicineGenericResource
    {
        $query = LibKonsultaMedicineGeneric::where('code', $medicineGeneric->code);
        $medicineGeneric = QueryBuilder::for($query)
            ->first();

        return new LibKonsultaMedicineGenericResource($medicineGeneric);
    }
}
