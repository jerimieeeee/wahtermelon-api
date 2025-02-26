<?php

namespace App\Console\Commands;

use App\Models\V1\Patient\Patient;
use App\Services\Patient\PatientVaccineService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ParseVaccineStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vaccine-status:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $patientvax = new PatientVaccineService();

        $getFicCic = DB::table(function ($query) use($patientvax) {
            $query->selectRaw("
                            fic_cic_vaccines.patient_id AS patient_id,
                            fic_cic_vaccines.vaccine_date AS vaccine_date,
                            BCG,
                            PENTA,
                            OPV,
                            MCV,
                            fic_cic_vaccines.status_id,
                            age_month
                ")
                ->from('patient_vaccines')
                ->joinSub($patientvax->get_fic_cic_vaccines(), 'fic_cic_vaccines', function ($join) {
                    $join->on('fic_cic_vaccines.patient_id', '=', 'patient_vaccines.patient_id');
                })
                ->whereIn('vaccine_id', ['BCG', 'PENTA', 'OPV', 'MCV'])
                ->groupBy('patient_vaccines.patient_id', 'patient_vaccines.vaccine_date', 'vaccine_id', 'status_id');
        })
            ->selectRaw('
                       patient_id,
                       vaccine_date,
                       CASE
                            WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month < 13
                            THEN "FIC"
                            WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month BETWEEN 13 AND 23
                            THEN "CIC"
                            WHEN BCG >= 1 AND PENTA >=3 AND OPV >=3 AND MCV >=2 AND age_month >= 24
                            THEN "COMPLETED"
                            END AS immunization_status
            ')->get();

        foreach ($getFicCic as $ficCic) {
            if (!is_null($ficCic->immunization_status)) {
                Patient::where('id', $ficCic->patient_id)
                    ->update(['immunization_status' => $ficCic->immunization_status,
                        'immunization_date' => $ficCic->vaccine_date
                    ]);
            }
        }
    }
}
