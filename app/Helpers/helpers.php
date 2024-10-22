<?php

use Carbon\Carbon;

if (! function_exists('get_aog')) {
    /**
     * @param  date  $lmp_date
     * @param  date  $visit_date
     * @return array
     */
    function get_aog($lmp_date, $visit_date)
    {
        $numberOfDays = $lmp_date->diff($visit_date)->days;
        $weeks = floor(($numberOfDays) / 7);
        $remainingDays = $numberOfDays % 7;

        return [$weeks, $remainingDays];
    }
}

if (! function_exists('get_trimester')) {
    /**
     * @param  date  $visit_date
     * @param  date  $trimester1_date
     * @param  date  $trimester2_date
     * @return int
     */
    function get_trimester($visit_date, $trimester1_date, $trimester2_date)
    {
        $trimester = 0;
        if ($visit_date <= $trimester1_date) {
            $trimester = 1;
        } elseif ($visit_date > $trimester1_date && $visit_date <= $trimester2_date) {
            $trimester = 2;
        } else {
            $trimester = 3;
        }

        return $trimester;
    }
}

if (! function_exists('get_postpartum_week')) {
    /**
     * @param  date  $visit_date
     * @param  date  $delivery_date
     * @return int
     */
    function get_postpartum_week($visit_date, $delivery_date)
    {
        $visit_date = Carbon::parse($visit_date);

        return $visit_date->diffInWeeks(Carbon::parse($delivery_date)->format('Y-m-d'));
    }
}

if (! function_exists('compute_bmi')) {
    function compute_bmi(float $weight, float $height): array
    {
        $height = $height / 100;
        $bmi = number_format($weight / ($height * $height), 1);
        $bmiClass = '';
        if ($bmi < 18.5) {
            $bmiClass = 'Underweight';
            $obesity = 'N';
        } elseif ($bmi >= 18.5 && $bmi < 23) {
            $bmiClass = 'Normal';
            $obesity = 'N';
        } elseif ($bmi >= 23 && $bmi < 25) {
            $bmiClass = 'Overweight';
            $obesity = 'N';
        } elseif ($bmi >= 25) {
            $bmiClass = 'Obese';
            $obesity = 'Y';
        }

        return [$bmi, $bmiClass];
    }
}

if (! function_exists('XML2JSON')) {
    function XML2JSON($xml)
    {
        $result = null;
        libxml_use_internal_errors(true);
        $xml = rtrim($xml, "\x00..\x1F\x7F");
        $data = simplexml_load_string($xml);
        if ($data !== false) {
            normalizeSimpleXML($data, $result);

            return json_decode(json_encode($result));
        } else {
            // The data is not XML
            return response()->json(['message' => 'The provided data does not conform to a valid XML format. This error may occur due to an incorrect Konsulta cipher key being used.'], 400);
        }

    }
}

if (! function_exists('normalizeSimpleXML')) {
    function normalizeSimpleXML($obj, &$result)
    {
        $data = $obj;
        if (is_object($data)) {
            $data = get_object_vars($data);
        }
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $res = null;
                normalizeSimpleXML($value, $res);
                if (($key == '@attributes') && ($key)) {
                    $result = $res;
                } else {
                    $result[$key] = $res;
                }
            }
        } else {
            $result = $data;
        }
    }
}

if (! function_exists('isJson')) {
    function isJson($data)
    {
        if (! empty($data)) {
            return is_string($data) &&
            is_array(json_decode($data, true)) ? true : false;
        }

        return false;
    }
}

if (! function_exists('get_completed_services')) {
    /**
     * @param  array  $iron
     * @param  date  $date
     * @param  int  $tablet
     * @return array
     */
    function get_completed_services($request, $service, $serviceQty, $age_year_bracket1, $age_year_bracket2)
    {
        $serviceArray = [];

        // Retrieve start and end dates from the request
        $start_date = Carbon::parse($request->start_date)->startOfDay();
        $end_date = Carbon::parse($request->end_date)->endOfDay();

        foreach ($service as $value) {
            // Break down the service quantity and service dates into arrays
            $quantity = explode(',', $value->service_qty);
            $dates = explode(',', $value->service_dates);

            $subtotal = 0;
            $serviceObject = [];

            foreach ($quantity as $k => $qty) {
                $subtotal += $qty;
                $serviceDate = Carbon::parse($dates[$k]);

                // Calculate age based on the date of birth and service date
                $age = Carbon::parse($value->birthdate)->diffInYears($serviceDate);

                // If the subtotal meets or exceeds the required service quantity
                if ($subtotal >= $serviceQty) {
                    // Check if the service date falls within the specified range
                    if ($serviceDate->between($start_date, $end_date)) {
                        // Prepare the service object
                        $serviceObject['name'] = $value->name;
                        $serviceObject['birthdate'] = $value->birthdate;
                        $serviceObject['date_of_service'] = $serviceDate->format('Y-m-d');

                        // Optionally, add more fields like municipality_code, barangay_code
                        // $serviceObject['municipality_code'] = $value->municipality_code;
                        // $serviceObject['barangay_code'] = $value->barangay_code;

                        // Check if the age falls within the provided age bracket
                        if ($age >= $age_year_bracket1 && $age <= $age_year_bracket2) {
                            $serviceArray[] = $serviceObject;
                        }
                    }
                    break; // Exit loop after finding the matching service date
                }
            }
        }

        return $serviceArray;
    }
}
