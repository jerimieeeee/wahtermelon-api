<?php

namespace App\Http\Controllers\API\V1\Medicine;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Medicine\MedicineListRequest;
use App\Http\Resources\API\V1\Medicine\MedicineListResource;
use App\Models\V1\Medicine\MedicineList;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Medicine List
 *
 * APIs for managing medicine lists
 *
 * @subgroup Medicine Lists
 *
 * @subgroupDescription Medicine lists management.
 */
class MedicineListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort prescription_date. Add hyphen (-) to descend the list: e.g. prescription_date. Example: -prescription_date
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Medicine\MedicinePrescriptionResource
     *
     * @apiResourceModel App\Models\V1\Medicine\MedicinePrescription paginate=15
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $columns = ['brand_name', 'added_medicine', 'dosage_quantity', 'dosage_uom'];
        $medicines = QueryBuilder::for(MedicineList::class)
            ->when(isset($request->filter['search']), function ($q) use ($request, $columns) {
                $q->orSearch($columns, 'LIKE', $request->filter['search'])
                ->orWhereHas('konsultaMedicine', function ($q) use ($request) {
                    $q->orSearch(['desc'], 'LIKE', $request->filter['search']);
                });
            })
            ->with(['medicine', 'konsultaMedicine', 'konsultaMedicine.generic', 'dosageUom', 'doseRegimen', 'medicinePurpose', 'durationFrequency', 'quantityPreparation', 'medicineRoute']);


        if ($perPage === 'all') {
            return MedicineListResource::collection($medicines->get());
        }

        return MedicineListResource::collection($medicines->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MedicineListRequest $request)
    {
        $data = MedicineList::create($request->validated());

        return response()->json(['data' => new MedicineListResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicineList $medicineList): MedicineListResource
    {
        return new MedicineListResource($medicineList);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicineListRequest $request, MedicineList $medicineList): JsonResponse
    {
        $medicineList->update($request->validated());

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicineList $medicineList)
    {
        $medicineList->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
