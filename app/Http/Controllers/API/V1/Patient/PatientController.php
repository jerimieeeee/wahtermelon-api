<?php

namespace App\Http\Controllers\API\V1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Patient\PatientRequest;
use App\Http\Resources\API\V1\Patient\PatientResource;
use App\Models\V1\Patient\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $columns = ['last_name', 'first_name', 'middle_name'];
        $patients = QueryBuilder::for(Patient::class)
            ->when(isset($request->filter['search']), function($q) use($request, $columns) {
                $q->search($request->filter['search'], $columns);
            })
            ->allowedIncludes('suffixName', 'pwdType', 'religion');
        if ($perPage === 'all') {
            return PatientResource::collection($patients->get());
        }

        return PatientResource::collection($patients->paginate($perPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PatientRequest $request
     * @return JsonResponse
     */
    public function store(PatientRequest $request): JsonResponse
    {
        $data = Patient::create($request->validated());
        return response()->json(['status' => 'Success', 'data' => $data], 201);
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
