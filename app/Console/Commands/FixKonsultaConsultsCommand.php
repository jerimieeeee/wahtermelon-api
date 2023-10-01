<?php

namespace App\Console\Commands;

use App\Models\V1\Consultation\Consult;
use Illuminate\Console\Command;

class FixKonsultaConsultsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:consults';

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
        $consults = Consult::query()->whereIsKonsulta(0)->wherePtGroup('cn')->whereHas('patient.philhealth.konsultaRegistration')->whereHas('finalDiagnosis')->update(['is_konsulta' => 1]);
        $this->info("$consults consults have been updated!");
    }
}
