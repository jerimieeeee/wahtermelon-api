<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibMcRiskFactorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lib_mc_risk_factors')->delete();
        DB::table('lib_mc_risk_factors')
      ->insert([
                ['id' => '1', 'risk_name' => 'Age younger than 15 years old or older than 35 years old.','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '2', 'risk_name' => 'Height lower than 145cm.','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '3', 'risk_name' => 'Poor OB history [3 consecutive miscarriages, stillbirth, postpartum hemorrhage]','hospital_flag' => '1','monitor_flag' => '0'],
                ['id' => '4', 'risk_name' => 'Leg and pelvic deformities [polio paralysis]','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '5', 'risk_name' => 'No prenatal or irregular prenatal in previous pregnancy','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '6', 'risk_name' => 'First pregnancy','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '7', 'risk_name' => 'Pregnancy more than 5','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '8', 'risk_name' => 'Pregnancy interval less than 24 months from the last delivery','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '9', 'risk_name' => 'Pregnancy longer than 294 days or 42 weeks','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '10','risk_name' => 'Pre-pregnancy weight less than 80% of standard weight','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '11','risk_name' => 'Anemia less than 8gm Hb','hospital_flag' => '0','monitor_flag' => '1'],
                ['id' => '12','risk_name' => 'Weight less than 4% of pre-pregnancy weight per trimester','hospital_flag' => '0','monitor_flag' => '1'],
                ['id' => '13','risk_name' => 'Weight gain more than 6% of pre-pregnancy weight per trimester','hospital_flag' => '0','monitor_flag' => '1'],
                ['id' => '14','risk_name' => 'Abnormal presentation','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '15','risk_name' => 'Multiple fetus','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '16','risk_name' => 'Blood pressure greater than 140/90','hospital_flag' => '0','monitor_flag' => '1'],
                ['id' => '17','risk_name' => 'Dizziness or blurring of vision','hospital_flag' => '0','monitor_flag' => '1'],
                ['id' => '18','risk_name' => 'Convulsions','hospital_flag' => '0','monitor_flag' => '1'],
                ['id' => '19','risk_name' => 'Positive urine albumin','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '20','risk_name' => 'Vaginal infections','hospital_flag' => '0','monitor_flag' => '1'],
                ['id' => '21','risk_name' => 'Vaginal bleeding','hospital_flag' => '0','monitor_flag' => '1'],
                ['id' => '22','risk_name' => 'Pitting edema','hospital_flag' => '0','monitor_flag' => '1'],
                ['id' => '23','risk_name' => 'Heart or kidney disease','hospital_flag' => '1','monitor_flag' => '0'],
                ['id' => '24','risk_name' => 'Tuberculosis','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '25','risk_name' => 'Malaria','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '26','risk_name' => 'Diabetes','hospital_flag' => '1','monitor_flag' => '0'],
                ['id' => '27','risk_name' => 'Rubella','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '28','risk_name' => 'Thyroid problems','hospital_flag' => '1','monitor_flag' => '0'],
                ['id' => '30','risk_name' => 'Mental disorder','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '31','risk_name' => 'Unwed mother','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '32','risk_name' => 'Illiterate mother','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '33','risk_name' => 'Perform heavy manual labor','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '34','risk_name' => 'Unwanted or unplanned pregnancy','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '35','risk_name' => 'Other socio-economic factors','hospital_flag' => '0','monitor_flag' => '0'],
                ['id' => '36','risk_name' => 'Previous cesarean section','hospital_flag' => '1','monitor_flag' => '0'],
                ['id' => '37','risk_name' => 'Bronchial asthma','hospital_flag' => '1','monitor_flag' => '0'],
                ['id' => '38','risk_name' => 'Having a fourth baby or more baby [grandmulti]','hospital_flag' => '0','monitor_flag' => '1']
            ]);
    }
}
