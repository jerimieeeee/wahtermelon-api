<?php

namespace App\Console\Commands;

use App\Models\V1\Konsulta\KonsultaTransmittal;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanKonsultaTransmittalsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'konsulta:clean';

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
        $firstTrancheDeleted = KonsultaTransmittal::query()
            ->whereDoesntHave('consult')
            ->whereTranche(2)
            ->whereXmlStatus('F')
            ->delete();

        $secondTrancheDeleted = KonsultaTransmittal::query()
            ->whereDoesntHave('philhealth')
            ->whereTranche(1)
            ->whereXmlStatus('F')
            ->delete();

        $totalDeleted = $firstTrancheDeleted + $secondTrancheDeleted;

        if ($totalDeleted > 0) {
            $message = "Total records deleted: $totalDeleted\n";
            $message .= "First tranche total deleted: $firstTrancheDeleted\n";
            $message .= "Second tranche total deleted: $secondTrancheDeleted";
        } else {
            $message = "No records deleted.";
        }

        $this->info($message);

    }
}
