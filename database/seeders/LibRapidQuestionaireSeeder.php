<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibRapidQuestionaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibRapidQuestionaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LibRapidQuestionaire::upsert([
            ['id' => 1, 'question' => 'Ikaw ba ay nakaranas ng pananakit o panananakot sa inyong bahay, paaralan o trabaho?', 'sequence' => 1],
            ['id' => 2, 'question' => 'May mgapagkakataon ba na pinag-isipan mo ng maglayas o umalis ng inyong bahay?', 'sequence' => 2],
            ['id' => 3, 'question' => 'Nakaranas ka ba ng bullying na pisikal o cyber bullying sa paaralan o sa trabaho?', 'sequence' => 3],
            ['id' => 4, 'question' => 'May pagkakataon ba na seryoso mong naisip na wakasan ang iyong buhay?', 'sequence' => 4],
            ['id' => 5, 'question' => 'Naninigarilyo ka ba?', 'sequence' => 5],
            ['id' => 6, 'question' => 'Umiinom ka ba ng alak?', 'sequence' => 6],
            ['id' => 7, 'question' => 'Nakakita ka na ba ng mgaipinagbabawal na "gamut" o drugs?', 'sequence' => 7],
            ['id' => 8, 'question' => 'Ikaw ba ay nakaranas ng magkarelasyon (boyfriend / girlfriend)?', 'sequence' => 8],
            ['id' => 9, 'question' => 'Ikaw ba ay nakaranas ng makipag sex o makipagtalik?', 'sequence' => 9],
            ['id' => 10, 'question' => 'Nakaranas ka ba na ikaw ay pinilit makipag sex?', 'sequence' => 10],
            ['id' => 11, 'question' => 'Ikaw ba ay nakaranas nang mabuntis, o makabuntis?', 'sequence' => 11],
            ['id' => 12, 'question' => 'Gusto mo bang mag pa counsel o komunsulta para matulungan ka?', 'sequence' => 12],
        ], ['id']);
    }
}
