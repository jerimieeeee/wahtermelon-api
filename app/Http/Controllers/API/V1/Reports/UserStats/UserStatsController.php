<?php

namespace App\Http\Controllers\API\V1\Reports\UserStats;

use App\Http\Controllers\Controller;
use App\Services\User\UserStatsService;
use Illuminate\Http\Request;

/**
 * @authenticated
 * @group Reports
 *
 * APIs for managing User Stats Report Information
 * @subgroup User Stats Report
 * @subgroupDescription Patient Registered.
 */
class UserStatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam year date to view.
     * @queryParam month date to view.
     * @param Request $request
     * @param UserStatsService $userStatsService
     */
    public function index(Request $request, UserStatsService $userStatsService)
    {
        //Patient registered per user
        $user_registered =  $userStatsService->get_count_users_registered_patients($request)->get();

        Return [
            //Patient registered per user
            'user_registered' => $user_registered,
        ];


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
