<?php

namespace App\Http\Controllers\API\V1\Medicine;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Medicine\MedicineDispensingRequest;
use App\Http\Resources\API\V1\Medicine\MedicineDispensingResource;
use App\Models\V1\Medicine\MedicineDispensing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Medicine Management
 *
 * APIs for managing medicines
 * @subgroup Medicine Dispensing
 * @subgroupDescription Medicine dispensing management.
 */
class MedicineDispensingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort dispensing_date. Add hyphen (-) to descend the list: e.g. dispensing_date. Example: -dispensing_date
     * @queryParam patient_id string Patient to view.
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\Medicine\MedicineDispensingResource
     * @apiResourceModel App\Models\V1\Medicine\MedicineDispensing paginate=15
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = MedicineDispensing::query()
            ->when(isset($request->patient_id), function($query) use($request){
                return $query->wherePatientId($request->patient_id);
            });
        $prescription = QueryBuilder::for($query)
            ->defaultSort('-dispensing_date')
            ->allowedSorts('dispensing_date');

        if ($perPage == 'all') {
            return MedicineDispensingResource::collection($prescription->get());
        }

        return MedicineDispensingResource::collection($prescription->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MedicineDispensingRequest $request
     * @return JsonResponse
     */
    public function store(MedicineDispensingRequest $request): JsonResponse
    {
        $data = MedicineDispensing::create($request->validated());
        return response()->json(['data' => new MedicineDispensingResource($data), 'status' => 'Success'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param MedicineDispensing $dispensing
     * @return MedicineDispensingResource
     */
    public function show(MedicineDispensing $dispensing): MedicineDispensingResource
    {
        return new MedicineDispensingResource($dispensing);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MedicineDispensingRequest $request
     * @param MedicineDispensing $dispensing
     * @return JsonResponse
     */
    public function update(MedicineDispensingRequest $request, MedicineDispensing $dispensing): JsonResponse
    {
        $dispensing->update($request->validated());
        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
