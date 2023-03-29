<?php

namespace App\Http\Controllers\API\V1\PhilHealth;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\PhilHealth\PhilhealtCredentialRequest;
use App\Http\Resources\API\V1\PhilHealth\PhilhealthCredentialResource;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 *
 * @group Settings
 *
 * APIs for managing philhealth information
 *
 * @subgroup Philhealth Credentials
 *
 * @subgroupDescription Philhealth credentials.
 */
class PhilhealthCredentialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam sort string Sort facility_name. Add hyphen (-) to descend the list: e.g. facility_name. Example: facility_name
     * @queryParam filter[program_code] string Program to view. Example: kp
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\PhilHealth\PhilhealthCredentialResource
     *
     * @apiResourceModel App\Models\V1\PhilHealth\PhilhealthCredential paginate=15
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;
        $credentials = QueryBuilder::for(PhilhealthCredential::class)
            ->defaultSort('facility_name')
            ->allowedSorts('facility_name')
            ->allowedFilters(['program_code']);

        if ($perPage == 'all') {
            return PhilhealthCredentialResource::collection($credentials->get());
        }

        return PhilhealthCredentialResource::collection($credentials->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store(PhilhealtCredentialRequest $request)
    {
        $data = PhilhealthCredential::updateOrCreate(['program_code' => $request->program_code], $request->all());

        return response()->json(['data' => new PhilhealthCredentialResource($data), 'status' => 'Success'], 201);
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
