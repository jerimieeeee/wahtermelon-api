<?php

namespace App\Http\Controllers\API\V1\Konsulta;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Konsulta\KonsultaRegistrationListResource;
use App\Models\V1\Konsulta\KonsultaRegistrationList;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Konsulta Information
 *
 * APIs for managing Konsulta Information
 *
 * @subgroup Registration Lists
 *
 * @subgroupDescription Registration lists.
 */
class KonsultaRegistrationListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam search string Filter by last_name, first_name or middle_name. Example: Juwahn Dela Cruz
     * @queryParam filter[philhealth_id] string Filter by philhealth_id. Example: 012345678987
     * @queryParam filter[effectivity_year] string Filter by effectivity_year. Example: 2023
     * @queryParam include string Relationship to view: e.g. assignedStatus,packageType,membershipType Example: assignedStatus,packageType,membershipType
     * @queryParam sort string Sort last_name, first_name, middle_name, birthdate, effectivity_year of the patient. Add hyphen (-) to descend the list: e.g. last_name,birthdate. Example: last_name
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\Konsulta\KonsultaRegistrationListResource
     *
     * @apiResourceModel App\Models\V1\Konsulta\KonsultaRegistrationList paginate=15
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $columns = ['last_name', 'first_name', 'middle_name'];
        $patients = QueryBuilder::for(KonsultaRegistrationList::class)
            ->when(isset($request->search), function ($q) use ($request, $columns) {
                $q->search($request->search, $columns);
            })
            ->allowedFilters(['philhealth_id', 'effectivity_year'])
            ->allowedIncludes('assignedStatus', 'packageType', 'membershipType')
            ->defaultSort('last_name', 'first_name', 'middle_name', 'birthdate', '-effectivity_year')
            ->allowedSorts(['last_name', 'first_name', 'middle_name', 'birthdate', 'effectivity_year']);
        if ($perPage === 'all') {
            return KonsultaRegistrationListResource::collection($patients->get());
        }

        return KonsultaRegistrationListResource::collection($patients->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
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
