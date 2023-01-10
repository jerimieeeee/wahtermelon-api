<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibComplaintResource;
use App\Models\V1\Libraries\LibComplaint;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Consultation
 *
 * APIs for managing libraries
 * @subgroup Chief Complaints
 * @subgroupDescription List of chief complaints.
 */

class LibComplaintController extends Controller
{
    /**
     * Display a listing of the Chief Complaints resource.
     *
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibComplaintResource
     * @apiResourceModel App\Models\V1\Libraries\LibComplaint
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $query = QueryBuilder::for(LibComplaint::class)
                ->whereKonsultaLibraryStatus(1);
        return LibComplaintResource::collection($query->get());

        if ($perPage === 'all') {
            return LibComplaintResource::collection($query->get());
        }
        return LibComplaintResource::collection($query->paginate($perPage)->withQueryString());
    }

    /**
     * Display the specified Chief Complaints resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibComplaintResource
     * @apiResourceModel App\Models\V1\Libraries\LibComplaint
     * @param LibComplaint $complaint_id
     * @return LibComplaintResource
     */

    public function show(LibComplaint $complaint_id, string $id): JsonResource
    {
        return new LibComplaintResource($complaint_id->findOrFail($id));
    }

}
