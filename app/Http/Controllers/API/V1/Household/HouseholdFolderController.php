<?php

namespace App\Http\Controllers\API\V1\Household;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Household\HouseholdFolderRequest;
use App\Http\Resources\API\V1\Household\HouseholdFolderResource;
use App\Models\V1\Household\HouseholdFolder;
use App\Models\V1\Household\HouseholdMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Household Information Management
 *
 * APIs for managing household information
 * @subgroup Household Folder
 * @subgroupDescription Household folder management.
 */
class HouseholdFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam filter[search] string Filter by last_name, first_name or middle_name. Example: Juwahn Dela Cruz
     * @queryParam include string Relationship to view: e.g. barangay Example: barangay
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\Household\HouseholdFolderResource
     * @apiResourceModel App\Models\V1\Household\HouseholdFolder paginate=15
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $columns = ['last_name', 'first_name', 'middle_name'];
        $household = QueryBuilder::for(HouseholdFolder::class)
            ->when(isset($request->filter['search']), function($q) use($request, $columns) {
                $q->whereHas('householdMember.patient', function($q) use($request, $columns){
                    $q->search($request->filter['search'], $columns);
                });
            })
            ->with('householdMember')
            ->allowedIncludes('barangay');

        if ($perPage === 'all') {
            return HouseholdFolderResource::collection($household->get());
        }

        return HouseholdFolderResource::collection($household->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResourceModel App\Models\V1\Household\HouseholdFolder
     * @param HouseholdFolderRequest $requestS
     * @return JsonResponse
     */
    public function store(HouseholdFolderRequest $request)
    {
        return DB::transaction(function() use($request){
            $checkPatient = HouseholdMember::wherePatientId($request->safe()->patient_id)->first();
            if($checkPatient) {
                return response()->json(['message' => 'Patient record is already in the household folder']);
            }
            $data = HouseholdFolder::create($request->validated());
            $data->householdMember()->updateOrCreate($request->safe()->only(['patient_id', 'user_id', 'family_role_code']));
            return new HouseholdFolderResource($data);
        });


    }

     /**
     * Display the specified resource.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Household\HouseholdFolderResource
     * @apiResourceModel App\Models\V1\Household\HouseholdFolder
     * @param PatientRequest $request
     * @return HouseholdFolderResource
     */
    public function show(HouseholdFolder $householdFolder): HouseholdFolderResource
    {
        $query = HouseholdFolder::where('id', $householdFolder->id);
        $householdFolder = QueryBuilder::for($query)
            ->allowedIncludes('barangay')
            ->first();
        return new HouseholdFolderResource($householdFolder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  HouseholdFolderRequest $request
     * @param  HouseholdFolder $householdFolder
     * @return \Illuminate\Http\Response
     */
    public function update(HouseholdFolderRequest $request, HouseholdFolder $householdFolder)
    {
        return DB::transaction(function() use($request, $householdFolder){
            $householdFolder->update($request->safe()->except(['patient_id', 'user_id', 'family_role_code']));
            HouseholdMember::query()
                ->updateOrCreate(['patient_id' => $request->safe()->patient_id], $request->safe()->only(['user_id', 'family_role_code']) + ['household_folder_id' => $householdFolder->id]);
            return response()->json(['status' => 'Update successful!'], 200);
        });
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
