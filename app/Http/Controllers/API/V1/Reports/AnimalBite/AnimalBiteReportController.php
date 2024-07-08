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
        return $animalbite->get_ab_post_exp_prophylaxis($request)->get();

//        //All Animal Bite Cases
//        $all_ab_case = $animalbite->get_animal_bite_case($request, 'all', 'all-age')->get();
//
//        //Male and Female
//        $all_male = $animalbite->get_animal_bite_case($request, 'M', 'all-male')->get();
//        $all_female = $animalbite->get_animal_bite_case($request, 'F', 'all-female')->get();
//
//        //Age less than 15 & Age greater than 15
//        $age_less_than_15 = $animalbite->get_animal_bite_case($request, 'all', 'less-than15')->get();
//        $age_15_up = $animalbite->get_animal_bite_case($request, 'all', 'greater-than15')->get();
//
//        //Type of Animal
//        //Dog
//        $type_of_animal_dog = $animalbite->get_animal_bite_case($request, 'dog', 'dog')->get();
//        //Cat
//        $type_of_animal_cat = $animalbite->get_animal_bite_case($request, 'cat', 'cat')->get();
//        //Bat
//        $type_of_animal_bat = $animalbite->get_animal_bite_case($request, 'bat', 'bat')->get();
//        //Monkey
//        $type_of_animal_monkey = $animalbite->get_animal_bite_case($request, 'monkey', 'monkey')->get();
//        //Others
//        $type_of_animal_others = $animalbite->get_animal_bite_case($request, 'others', 'others')->get();
//
//        //Animal Bite Category
//        //Category 1
//        $animal_bite_category_1 = $animalbite->get_animal_bite_case($request, 'cat1', 'cat1')->get();
//        //Category 2
//        $animal_bite_category_2 = $animalbite->get_animal_bite_case($request, 'cat2', 'cat2')->get();
//        //Category 3
//        $animal_bite_category_3 = $animalbite->get_animal_bite_case($request, 'cat3', 'cat3')->get();
//
//        return [
//
//            //All Animal Bite Cases
//            'all_ab_case' => $all_ab_case,
//
//            //Male and Female
//            '$all_male'=> $all_male,
//            '$all_female'=> $all_female,
//
//            //Age less than 15 & Age greater than 15
//            'age_less_than_15' => $age_less_than_15,
//            'age_15_up' => $age_15_up,
//
//            //Type of Animal
//            //Dog
//            'type_of_animal_dog' => $type_of_animal_dog,
//            //Cat
//            'type_of_animal_cat' => $type_of_animal_cat,
//            //Bat
//            'type_of_animal_bat' => $type_of_animal_bat,
//            //Monkey
//            'type_of_animal_monkey' => $type_of_animal_monkey,
//            //Others
//            'type_of_animal_others' => $type_of_animal_others,
//
//            //Animal Bite Category
//            //Category 1
//            'animal_bite_category_1' => $animal_bite_category_1,
//            //Category 2
//            'animal_bite_category_2' => $animal_bite_category_2,
//            //Category 3
//            'animal_bite_category_3' => $animal_bite_category_3,
//        ];
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
