<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\UserRequest;
use App\Http\Requests\API\V1\UserUpdateRequest;
use App\Http\Resources\API\V1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @group User Information Management
 *
 * APIs for managing user information
 *
 * @subgroup User
 *
 * @subgroupDescription User management.
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @authenticated
     *
     * @queryParam filter[search] string Filter by last_name, first_name or middle_name. Example: Juwahn Dela Cruz
     * @queryParam designation_code string Filter by designation code. Example: MD
     * @queryParam sort string Sort last_name, first_name, middle_name, birthdate of the user. Add hyphen (-) to descend the list: e.g. last_name,birthdate. Example: last_name
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\API\V1\UserResource
     *
     * @apiResourceModel App\Models\User paginate=15
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $columns = ['last_name', 'first_name', 'middle_name'];
        $user = QueryBuilder::for(User::class)
            ->when(isset($request->filter['search']), function ($q) use ($request, $columns) {
                $q->search($request->filter['search'], $columns);
            })
            ->when(isset($request->designation_code), function ($q) use ($request) {
                $q->whereDesignationCode($request->designation_code);
            })
            ->with('facility', 'designation', 'employer')
            ->allowedIncludes('suffixName')
            ->defaultSort('last_name', 'first_name', 'middle_name', 'birthdate')
            ->allowedSorts(['last_name', 'first_name', 'middle_name', 'birthdate']);
        if ($perPage === 'all') {
            return UserResource::collection($user->get());
        }

        return UserResource::collection($user->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @apiResourceAdditional status=Success
     *
     * @apiResource 201 App\Http\Resources\API\V1\UserResource
     *
     * @apiResourceModel App\Models\User
     */
    public function store(UserRequest $request): JsonResponse
    {
        $data = User::create($request->validated());

        return response()->json(['status' => 'Success', 'date' => new UserResource($data)], 201);
    }

    /**
     * Display the specified resource.
     *
     * @authenticated
     *
     * @apiResource App\Http\Resources\API\V1\UserResource
     *
     * @apiResourceModel App\Models\User
     */
    public function show(User $user): UserResource
    {
        $query = User::where('id', $user->id);
        $user = QueryBuilder::for($query)
            ->with('facility', 'designation', 'employer')
            ->first();

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());

        return response()->json(['status' => 'Update successful!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @authenticated
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
