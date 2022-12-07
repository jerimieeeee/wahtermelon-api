<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibIcd10NotifiableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['P35.8','A80','A80.1','A80.2','A80.3','A80.4','A80.9','A22','A22.0',
          'A22.1','A22.2','A22.7','A22.8','A22.9','A98.4','B08.8','J10.0','J10.1',
          'J10.8','B05','B05.0','B05.1','B05.2','B05.3','B05.4','B05.8','B05.9',
          'B06','B06.0','B06.8','B06.9','J17.1','A39','A39.0','A39.2','A39.3',
          'A39.4','A39.5','A39.8','A39.9','B34.2','A33','P71.3','T61.0','T61.1',
          'T61.1','T61.2','T61.8','A82','A82.0','A82.1','A82.9','U04.9','Q02','A92.8'])
        ->update(['notifiable_cat' => 1]);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A06','A06.0','A06.1','A09','A32.1','A83','A83.0','A83.8','A83.9','A86',
          'B15','B15.9','B16','B17','B17.0','B17.1','B17.2','B17.8','B18','B18.2',
          'B18.8','B18.9','B19','G00','G00.8','G00.9','G03.1','G03.9','A92.0','A00',
          'A00.0','A00.1','A00.9','A90','A91','A91.1','A91.2','A91.3','A91.9','A36',
          'A36.0','A36.1','A36.2','A36.3','A36.8','A36.9','J10','J11','A27','A27.0',
          'A27.8','A27.9','B50','B50.0','B50.8','B50.9','B51','B51.0','B51.8','B51.9',
          'B52','B52.0','B52.8','B52.9','B53','B53.0','B53.1','B53.8','B54','D63.8',
          'D77','G94.8','A34','A35','A37','A37.0','A37.1','A37.8','A37.9','A08.0',
          'A01','A01.0','A01.1','A01.2','A01.3','A01.4'])
        ->update(['notifiable_cat' => 2]);

    DB::table('lib_icd10s')
        ->whereNotNull('icd10_code')
        ->update(['is_morbidity' => '1']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['P35.8'])
        ->update(['notifiable_name' => 'Accute Flaccid Paralysis']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A06','A06.0','A06.1','A09'])
        ->update(['notifiable_name' => 'Acute Bloody Diarrhea']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A32.1','A83','A83.0','A83.8','A83.9','A86'])
        ->update(['notifiable_name' => 'Acute Encephalitis Syndrome']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A80','A80.0','A80.1','A80.2','A80.3','A80.4','A80.9'])
        ->update(['notifiable_name' => 'Acute Flaccid Paralysis']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A92.8'])
        ->update(['notifiable_name' => 'Acute Hemmorrhagic Fever Syndrome']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['B15','B15.9','B16','B17','B17.0','B17.1','B17.2','B17.8','B18','B18.2','B18.8','B18.9','B19'])
        ->update(['notifiable_name' => 'Acute Viral Hepatitis']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A22','A22.0','A22.1','A22.2','A22.7','A22.8','A22.9'])
        ->update(['notifiable_name' => 'Anthrax']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['G00','G00.8','G00.9','G03.1','G03.9'])
        ->update(['notifiable_name' => 'Bacterial Meningitis']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A92.0'])
        ->update(['notifiable_name' => 'Chikungunya']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A00','A00.0','A00.1','A00.9'])
        ->update(['notifiable_name' => 'Cholera']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A90','A91','A91.1','A91.2','A91.3','A91.9'])
        ->update(['notifiable_name' => 'Dengue']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A36','A36.0','A36.1','A36.2','A36.3','A36.8','A36.9'])
        ->update(['notifiable_name' => 'Diphtheria']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A98.4'])
        ->update(['notifiable_name' => 'Ebola']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['B08.8'])
        ->update(['notifiable_name' => 'Hand Foot and Mouth Disease']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['J10.0','J10.1','J10.8'])
        ->update(['notifiable_name' => 'Human Avian Influenza']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['J10','J11'])
        ->update(['notifiable_name' => 'Influenza-like Illness']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A27','A27.0','A27.8','A27.9'])
        ->update(['notifiable_name' => 'Leptospirosis']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['B50','B50.0','B50.8','B50.9','B51','B51.0','B51.8','B51.9','B52','B52.0','B52.8','B52.9','B53','B53.0','B53.1','B53.8','B54','D63.8','D77','G94.8'])
        ->update(['notifiable_name' => 'Malaria']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['B05','B05.0','B05.1','B05.2','B05.3','B05.4','B05.8','B05.9','B06','B06.0','B06.8','B06.9','J17.1'])
        ->update(['notifiable_name' => 'Measles']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A39','A39.0','A39.2','A39.3','A39.4','A39.5','A39.8','A39.9'])
        ->update(['notifiable_name' => 'Meningococcal Disease']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['B34.2'])
        ->update(['notifiable_name' => 'MersCoV']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A33','P71.3'])
        ->update(['notifiable_name' => 'Neonatal Tetanus']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A34','A35'])
        ->update(['notifiable_name' => 'Non-neonatal Tetanus']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['T61.0','T61.1','T61.2','T61.8'])
        ->update(['notifiable_name' => 'Paralytic Shellfish Poisoning']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A37','A37.0','A37.1','A37.8','A37.9'])
        ->update(['notifiable_name' => 'Pertussis']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A82','A82.0','A82.1','A82.9'])
        ->update(['notifiable_name' => 'Rabies']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A08.0'])
        ->update(['notifiable_name' => 'Rotavirus']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['U04.9'])
        ->update(['notifiable_name' => 'Severe Acute Respiratory Syndrome']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['A01','A01.0','A01.1','A01.2','A01.3','A01.4'])
        ->update(['notifiable_name' => 'Typhoid and Paratyphoid Fever']);

    DB::table('lib_icd10s')
        ->whereIn('icd10_code', ['Q02'])
        ->update(['notifiable_name' => 'Zika']);
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
      //
  }
}
