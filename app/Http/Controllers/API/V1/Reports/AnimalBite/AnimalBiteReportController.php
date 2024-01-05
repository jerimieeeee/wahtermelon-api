<?php

namespace App\Http\Controllers\API\V1\Reports\AnimalBite;

use App\Http\Controllers\Controller;
use App\Services\AnimalBite\AnimalBiteReportService;
use Illuminate\Http\Request;

class AnimalBiteReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AnimalBiteReportService $animalbite)
    {
        //All Animal Bite Cases
        $all_ab_case = $animalbite->get_animal_bite_case($request, 'all', 'all-age')->get();

        //Male and Female
        $all_male = $animalbite->get_animal_bite_case($request, 'M', 'all-male')->get();
        $all_female = $animalbite->get_animal_bite_case($request, 'F', 'all-female')->get();

        //Age less than 15 & Age greater than 15
        $age_less_than_15 = $animalbite->get_animal_bite_case($request, 'all', 'less-than15')->get();
        $age_15_up = $animalbite->get_animal_bite_case($request, 'all', 'greater-than15')->get();

        return [

            //All Animal Bite Cases
            'all_ab_case' => $all_ab_case,

            //Male and Female
            '$all_male'=> $all_male,
            '$all_female'=> $all_female,

            //Age less than 15 & Age greater than 15
            'age_less_than_15' => $age_less_than_15,
            'age_15_up' => $age_15_up,
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
