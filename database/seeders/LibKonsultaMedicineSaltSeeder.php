<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibKonsultaMedicineSalt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibKonsultaMedicineSaltSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibKonsultaMedicineSalt::upsert([
            ["code" => "00000", "desc" => ""],
            ["code" => "00001", "desc" => "ACETATE"],
            ["code" => "00002", "desc" => "HYDROCHLORIDE"],
            ["code" => "00003", "desc" => "SALICYLATE"],
            ["code" => "00004", "desc" => "TROMETHAMOL"],
            ["code" => "00005", "desc" => "ACETONIDE"],
            ["code" => "00006", "desc" => "ANHYDROUS"],
            ["code" => "00007", "desc" => "AXETIL"],
            ["code" => "00008", "desc" => "BENZOATE"],
            ["code" => "00009", "desc" => "BESILATE"],
            ["code" => "00010", "desc" => "BITARTRATE"],
            ["code" => "00011", "desc" => "BROMIDE"],
            ["code" => "00012", "desc" => "CALCIUM"],
            ["code" => "00013", "desc" => "CHLORIDE"],
            ["code" => "00014", "desc" => "CILEXETIL"],
            ["code" => "00015", "desc" => "CITRATE"],
            ["code" => "00016", "desc" => "DECANOATE"],
            ["code" => "00017", "desc" => "DIHYDRATE"],
            ["code" => "00018", "desc" => "DIHYDROCHLORIDE"],
            ["code" => "00019", "desc" => "DIPROPIONATE"],
            ["code" => "00020", "desc" => "DISODIUM/SODIUM SALT"],
            ["code" => "00021", "desc" => "ENANTHATE"],
            ["code" => "00022", "desc" => "ETHYL SUCCINATE"],
            ["code" => "00023", "desc" => "FUMARATE"],
            ["code" => "00024", "desc" => "FUMARATE DIHYDRATE"],
            ["code" => "00025", "desc" => "FUROATE"],
            ["code" => "00026", "desc" => "GLUCONATE"],
            ["code" => "00027", "desc" => "HYCLATE"],
            ["code" => "00028", "desc" => "HYDRATE + DIPROPIONATE"],
            ["code" => "00029", "desc" => "HYDROBROMIDE"],
            ["code" => "00030", "desc" => "HYDROCHLORIDE DIHYDRATE"],
            ["code" => "00031", "desc" => "HYDROGEN TARTRATE"],
            ["code" => "00032", "desc" => "LACTATE"],
            ["code" => "00033", "desc" => "MACROCRYSTALS"],
            ["code" => "00034", "desc" => "MALEATE"],
            ["code" => "00035", "desc" => "MEGLUMINE"],
            ["code" => "00036", "desc" => "MEGLUMINE AND/OR SODIUM SALT"],
            ["code" => "00037", "desc" => "MESILATE"],
            ["code" => "00038", "desc" => "MONOHYDRATE"],
            ["code" => "00039", "desc" => "MONOHYDROCHLORIDE"],
            ["code" => "00040", "desc" => "MYCOPHENOLATE SODIUM"],
            ["code" => "00041", "desc" => "N-BUTYL BROMIDE"],
            ["code" => "00042", "desc" => "NITROGLYCERINE"],
            ["code" => "00043", "desc" => "OXALATE"],
            ["code" => "00044", "desc" => "PALMITATE"],
            ["code" => "00045", "desc" => "PALMITATE HYDROCHLORIDE"],
            ["code" => "00046", "desc" => "PENTAHYDRATE"],
            ["code" => "00047", "desc" => "PHOSPHATE"],
            ["code" => "00048", "desc" => "PHOSPHATE OR DIPHOSPHATE"],
            ["code" => "00049", "desc" => "POTASSIUM SALT"],
            ["code" => "00050", "desc" => "PROPIONATE"],
            ["code" => "00051", "desc" => "SODIUM"],
            ["code" => "00052", "desc" => "SODIUM PHOSPHATE"],
            ["code" => "00053", "desc" => "SODIUM SALT"],
            ["code" => "00054", "desc" => "SODIUM SUCCINATE"],
            ["code" => "00055", "desc" => "STEARATE"],
            ["code" => "00056", "desc" => "TARTRATE"],
            ["code" => "00057", "desc" => "TRIHYDRATE"],
            ["code" => "00058", "desc" => "TYDROCHLORIDE"],
            ["code" => "00059", "desc" => "VALERATE"],
            ["code" => "00060", "desc" => "SULFATE"],
        ], ['code']);
    }
}
