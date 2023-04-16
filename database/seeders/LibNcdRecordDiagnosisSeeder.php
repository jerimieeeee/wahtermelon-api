<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibNcdRecordDiagnosis;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class LibNcdRecordDiagnosisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        LibNcdRecordDiagnosis::truncate();
        Schema::enableForeignKeyConstraints();

        LibNcdRecordDiagnosis::upsert([
            ['desc' => 'With cardiovascular risk factors only'],
            ['desc' => 'Secondary hypertension'],
            ['desc' => 'Renal disease (albuminuria > 3g/L, createnine > 177 mol/L or 2mg/dl'],
            ['desc' => 'Coronary heart disease'],
            ['desc' => 'Cerebrovascular disease'],
            ['desc' => 'Essential hypertension'],
            ['desc' => 'Diabetes'],
            ['desc' => 'Congestive heart disease'],
            ['desc' => 'Peripheral vascular disease'],
        ], ['id']);
    }
}
