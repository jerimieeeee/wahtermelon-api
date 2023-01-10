<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMedicalHistoryResource;
use App\Models\V1\Libraries\LibMedicalHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Patient Medical History
 *
 * APIs for managing libraries
 * @subgroup Patient Medical History
 * @subgroupDescription List of Patient Medical History.
 */
class LibMedicalHistoryController extends Controller
{
    /**
     * Display a listing of the Patient Medical History resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMedicalHistoryResource
     * @apiResourceModel App\Models\V1\Libraries\LibMedicalHistory
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = QueryBuilder::for(LibMedicalHistory::class)
                ->whereKonsultaLibraryStatus(1);
        return LibMedicalHistoryResource::collection($query->get());

        if ($perPage === 'all') {
            return LibMedicalHistoryResource::collection($query->get());
        }
        return LibMedicalHistoryResource::collection($query->paginate($perPage)->withQueryString());
    }
    /**
     * Display the specified Patient Medical History Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMedicalHistoryResource
     * @apiResourceModel App\Models\V1\Libraries\LibMedicalHistory
     * @param LibMedicalHistory $answer
     * @return LibMedicalHistoryResource
     */
    public function show(LibMedicalHistory $medicalHistory): LibMedicalHistoryResource
    {
        $query = LibMedicalHistory::where('id', $medicalHistory->id);
        $medicalHistory = QueryBuilder::for($query)
            ->first();
        return new LibMedicalHistoryResource($medicalHistory);
    }
}
