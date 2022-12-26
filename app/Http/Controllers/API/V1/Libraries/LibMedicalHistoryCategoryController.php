<?php

namespace App\Http\Controllers\API\V1\Libraries;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Libraries\LibMedicalHistoryCategoryResource;
use App\Models\V1\Libraries\LibMedicalHistoryCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group Libraries for Patient Medical History
 *
 * APIs for managing libraries
 * @subgroup Patient Medical History Category
 * @subgroupDescription List of Patient Medical History Category.
 */
class LibMedicalHistoryCategoryController extends Controller
{
    /**
     * Display a listing of the Patient Medical History Category resource.
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Libraries\LibMedicalHistoryCategoryResource
     * @apiResourceModel App\Models\V1\Libraries\LibMedicalHistoryCategory
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $query = QueryBuilder::for(LibMedicalHistoryCategory::class);
        return LibMedicalHistoryCategoryResource::collection($query->get());
    }
        /**
     * Display the specified Patient Medical History Resource.
     *
     * @apiResource App\Http\Resources\API\V1\Libraries\LibMedicalHistoryResource
     * @apiResourceModel App\Models\V1\Libraries\LibMedicalHistory
     * @param LibMedicalHistoryCategory $medicalHistoryCategory
     * @return LibMedicalHistoryCategory
     */
    public function show(LibMedicalHistoryCategory $medicalHistoryCategory): LibMedicalHistoryCategoryResource
    {
        $query = LibMedicalHistoryCategory::where('id', $medicalHistoryCategory->id);
        $medicalHistoryCategory = QueryBuilder::for($query)
            ->first();
        return new LibMedicalHistoryCategoryResource($medicalHistoryCategory);
    }
}
