<?php

namespace App\Http\Controllers\API\V1\Medicine;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Medicine\MedicinePrescriptionRequest;
use App\Http\Resources\API\V1\Medicine\MedicinePrescriptionResource;
use App\Models\V1\Medicine\MedicinePrescription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

/**
 * @authenticated
 *
 * @group Medicine Management
 *
 * APIs for managing medicines
 *
 * @subgroup Medicine Prescriptions
 *
 * @subgroupDescription Medicine prescription management.
 */
class MedicinePrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort prescription_date. Add hyphen (-) to descend the list: e.g. prescription_date. Example: -prescription_date
     * @queryParam patient_id string Patient to view.
     * @queryParam consult_id string Consult to view.
     * @queryParam status string Status to view. e.g. dispensing. Example: dispensing
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
        $query = MedicinePrescription::query()
            ->when(isset($request->patient_id), function ($query) use ($request) {
                return $query->wherePatientId($request->patient_id);
            })
            ->when(isset($request->consult_id), function ($query) use ($request) {
                return $query->whereConsultId($request->consult_id);
            })
            ->when(isset($request->status) && $request->status == 'dispensing', function ($query) {
                $query->withSum('dispensing', 'dispense_quantity')
                    ->havingRaw('quantity > dispensing_sum_dispense_quantity OR dispensing_sum_dispense_quantity IS NULL');
            });
        $prescription = QueryBuilder::for($query)
            ->with(['konsultaMedicine', 'medicine', 'dosageUom', 'doseRegimen', 'medicinePurpose', 'durationFrequency', 'quantityPreparation', 'medicineRoute', 'prescribedBy', 'dispensing'])
            ->defaultSort('-prescription_date')
            ->allowedSorts('prescription_date');

        if ($perPage == 'all') {
            return MedicinePrescriptionResource::collection($prescription->get());
        }

        return MedicinePrescriptionResource::collection($prescription->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(MedicinePrescriptionRequest $request)
    {
        $data = MedicinePrescription::create($request->validated());

        return response()->json(['data' => new MedicinePrescriptionResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicinePrescription $prescription): MedicinePrescriptionResource
    {
        return new MedicinePrescriptionResource($prescription);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MedicinePrescriptionRequest $request, MedicinePrescription $prescription): JsonResponse
    {
        $prescription->update($request->validated());

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws Throwable
     */
    public function destroy(MedicinePrescription $prescription): JsonResponse
    {
        $prescription->deleteOrFail();

        return response()->json(['status' => 'Successfully deleted!'], 200);
    }
}
