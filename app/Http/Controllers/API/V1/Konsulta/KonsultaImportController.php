<?php

namespace App\Http\Controllers\API\V1\Konsulta;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Konsulta\KonsultaImportResource;
use App\Models\V1\Konsulta\KonsultaImport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Konsulta Information
 *
 * APIs for managing Konsulta Information
 * @subgroup Imported XML Lists
 * @subgroupDescription Imported XML lists.
 */
class KonsultaImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam filter[transmittal_number] string Filter by transmittal_number.
     * @queryParam include string Relationship to view: e.g. facility,user Example: facility,user
     * @queryParam sort string Sort created_at. Add hyphen (-) to descend the list. Example: created_at
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\Konsulta\KonsultaImportResource
     * @apiResourceModel App\Models\V1\Konsulta\KonsultaImport paginate=15
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $files = QueryBuilder::for(KonsultaImport::class)
            ->allowedFilters(['transmittal_number'])
            ->allowedIncludes('facility', 'user')
            ->defaultSort('-created_at')
            ->allowedSorts(['created_at']);
        if ($perPage === 'all') {
            return KonsultaImportResource::collection($files->get());
        }

        return KonsultaImportResource::collection($files->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
