<?php

namespace App\Http\Controllers\API\V1\Reports\DOH;

use App\Http\Controllers\Controller;
use App\Services\Notifiable\NotifiableReportService;
use Illuminate\Http\Request;

class NotifiableWeeklyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, NotifiableReportService $notifiableWeekly)
    {
        //// CATEGORY I

        //Accute Flaccid Paralysis
        $accuteparalysis = $notifiableWeekly->get_notifiable($request, 'paralysis')->get();

        //Anthax
        $anthrax = $notifiableWeekly->get_notifiable($request, 'anthrax')->get();

        //Human Avian Influenza
        $avianinfluenza = $notifiableWeekly->get_notifiable($request, 'avian')->get();

        //Measles
        $measles = $notifiableWeekly->get_notifiable($request, 'measles')->get();

        //Meningococcal
        $meningococcal = $notifiableWeekly->get_notifiable($request, 'meningococcal')->get();

        //Neonatal Tetanus
        $neotetanus = $notifiableWeekly->get_notifiable($request, 'neo-tetanus')->get();

        //Paralytic Shellfish Poisoning
        $shellfish = $notifiableWeekly->get_notifiable($request, 'shellfish')->get();

        //Rabies
        $rabies = $notifiableWeekly->get_notifiable($request, 'rabies')->get();

        //SARS
        $sars = $notifiableWeekly->get_notifiable($request, 'sars')->get();

        //// CATEGORY II

        //Acute Bloody Diarrhea
        $diarrhea = $notifiableWeekly->get_notifiable($request, 'diarrhea')->get();

        //Acute Encephalitis Syndrome
        $encephalitis = $notifiableWeekly->get_notifiable($request, 'encephalitis')->get();

        //Acute Hemorrhagic Fever Syndrome
        $fever = $notifiableWeekly->get_notifiable($request, 'fever')->get();

        //Acute Viral Hepatitis
        $hepatitis = $notifiableWeekly->get_notifiable($request, 'hepatitis')->get();

        //Bacterial Meningitis
        $meningitis = $notifiableWeekly->get_notifiable($request, 'meningitis')->get();

        //Cholera
        $cholera = $notifiableWeekly->get_notifiable($request, 'cholera')->get();

        //Dengue
        $dengue = $notifiableWeekly->get_notifiable($request, 'dengue')->get();

        //Diphtheria
        $diphtheria = $notifiableWeekly->get_notifiable($request, 'diphtheria')->get();

        //Influenza-like Illness
        $influenza = $notifiableWeekly->get_notifiable($request, 'influenza')->get();

        //Leptospirosis
        $leptospirosis = $notifiableWeekly->get_notifiable($request, 'leptospirosis')->get();

        //Malaria
        $malaria = $notifiableWeekly->get_notifiable($request, 'malaria')->get();

        //Non-neonatal Tetanus
        $nontetanus = $notifiableWeekly->get_notifiable($request, 'non-tetanus')->get();

        //Pertussis
        $pertussis = $notifiableWeekly->get_notifiable($request, 'pertussis')->get();

        //Typhoid and Paratyphoid Fever
        $typhoid = $notifiableWeekly->get_notifiable($request, 'typhoid')->get();

        return [

            //CATEGORY I

            //Accute Flaccid Paralysis
            'Accute Flaccid Paralysis' => $accuteparalysis,

            //Anthax
            'Anthax' => $anthrax,

            //Human Avian Influenza
            'Human Avian Influenza' => $avianinfluenza,

            //Measles
            '$measles' => $measles,

            //Meningococcal
            'meningococcal' => $meningococcal,

            //Neonatal Tetanus
            'neotetanus' => $neotetanus,

            //Paralytic Shellfish Poisoning
            'shellfish' => $shellfish,

            //Rabies
            '$rabies' => $rabies,

            //SARS
            'sars' => $sars,

            //// CATEGORY II

            //Acute Bloody Diarrhea
            'diarrhea' => $diarrhea,

            //Acute Encephalitis Syndrome
            'encephalitis' => $encephalitis,

            //Acute Hemorrhagic Fever Syndrome
            'fever' => $fever,

            //Acute Viral Hepatitis
            'hepatitis' => $hepatitis,

            //Bacterial Meningitis
            'meningitis' => $meningitis,

            //Cholera
            'cholera' => $cholera,

            //Dengue
            'dengue' => $dengue,

            //Diphtheria
            'diphtheria' => $diphtheria,

            //Influenza-like Illness
            'influenza' => $influenza,

            //Leptospirosis
            'leptospirosis' => $leptospirosis,

            //Malaria
            'malaria' => $malaria,

            //Non-neonatal Tetanus
            'nontetanus' => $nontetanus,

            //Pertussis
            '$pertussis' => $pertussis,

            //Typhoid and Paratyphoid Fever
            'typhoid' => $typhoid,

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
