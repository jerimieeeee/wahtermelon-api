<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParseICD10Command extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'icd10:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse ICD10 Library from PhilHealth Konsulta';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
