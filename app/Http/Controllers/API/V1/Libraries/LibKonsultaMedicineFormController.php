<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineFormResource;
use App\Models\V1\Libraries\LibKonsultaMedicineForm;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Konsulta Medicine
 *
 * APIs for managing libraries
 *
 * @subgroup Medicine Forms
 *
 * @subgroupDescription List of medicine forms.
 */
class LibKonsultaMedicineFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineFormResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicineForm
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = QueryBuilder::for(LibKonsultaMedicineForm::class);

        if ($perPage === 'all') {
            return LibKonsultaMedicineFormResource::collection($query->get());
        }

        return LibKonsultaMedicineFormResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Display the specified resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibKonsultaMedicineFormResource
     *
     * @apiResourceModel App\Models\V1\Libraries\LibKonsultaMedicineForm
     */
    public function show(LibKonsultaMedicineForm $medicineForm): LibKonsultaMedicineFormResource
    {
        $query = LibKonsultaMedicineForm::where('code', $medicineForm->code);
        $medicineForm = QueryBuilder::for($query)
            ->first();

        return new LibKonsultaMedicineFormResource($medicineForm);
    }
}
