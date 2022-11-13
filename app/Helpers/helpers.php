<?php

if(!function_exists('get_aog')) {
    /**
    * @param date $lmp_date
    * @param date $visit_date
    * @return array
    */

    function get_aog($lmp_date, $visit_date)
    {
        $numberOfDays = $lmp_date->diff($visit_date)->days;
        $weeks = floatval(($numberOfDays) / 7);
        $remainingDays = $numberOfDays % 7;

        return array($weeks,$remainingDays);
    }
}

if(!function_exists('get_trimester')) {
    /**
     * @param date $visit_date
     * @param date $trimester1_date
     * @param date $trimester2_date
     * @return integer
    */

    function get_trimester($visit_date, $trimester1_date, $trimester2_date)
    {
        $trimester = 0;
        if ($visit_date <= $trimester1_date) {
            $trimester = 1;
        } else if ($visit_date > $trimester1_date && $visit_date <= $trimester2_date) {
            $trimester = 2;
        } else {
            $trimester = 3;
        }
        return $trimester;
    }

}
