<?php

namespace App\Http\Controllers\API\V1\Household;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Household\HouseholdFolderRequest;
use App\Http\Resources\API\V1\Household\HouseholdFolderResource;
use App\Models\V1\Household\HouseholdFolder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class HouseholdFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $columns = ['last_name', 'first_name', 'middle_name'];
        $household = QueryBuilder::for(HouseholdFolder::class)
            ->when(isset($request->filter['search']), function($q) use($request, $columns) {
                $q->whereHas('householdMember.patient', function($q) use($request, $columns){
                    $q->search($request->filter['search'], $columns);
                });
            });

        if ($perPage === 'all') {
            return HouseholdFolderResource::collection($household->get());
        }

        return HouseholdFolderResource::collection($household->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HouseholdFolderRequest $request)
    {
        $data = HouseholdFolder::create($request->validated());
        $data->householdMember()->create($request->validated());
        return HouseholdFolderResource::collection($data);
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
