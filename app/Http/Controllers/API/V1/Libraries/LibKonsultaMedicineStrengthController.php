<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineStrengthResource;
use App\Models\V1\Libraries\LibKonsultaMedicineStrength;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Konsulta Medicine
 *
 * APIs for managing libraries
 *
 * @subgroup Medicine Strengths
 *
 * @subgroupDescription List of medicine strengths.
 */
class LibKonsultaMedicineStrengthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineStrengthResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicineStrength
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = QueryBuilder::for(LibKonsultaMedicineStrength::class);

        if ($perPage === 'all') {
            return LibKonsultaMedicineStrengthResource::collection($query->get());
        }

        return LibKonsultaMedicineStrengthResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineStrengthResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicineStrength
     */
    public function show(LibKonsultaMedicineStrength $medicineStrength): LibKonsultaMedicineStrengthResource
    {
        $query = LibKonsultaMedicineStrength::where('code', $medicineStrength->code);
        $medicineStrength = QueryBuilder::for($query)
            ->first();

        return new LibKonsultaMedicineStrengthResource($medicineStrength);
    }
}
