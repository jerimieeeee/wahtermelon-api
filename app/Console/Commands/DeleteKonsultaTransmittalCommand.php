<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteKonsultaTransmittalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transmittal:delete';

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
        $batchSize = 1000; // Adjust based on your needs
        $firstTrancheDeleted = 0;
        $secondTrancheDeleted = 0;

        // Delete records for the first tranche in batches
        do {
            $deleted = DB::table('konsulta_transmittals')
                ->where('tranche', 1)
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('patient_philhealth')
                        ->whereRaw('patient_philhealth.transmittal_number = konsulta_transmittals.transmittal_number')
                        ->where('konsulta_transmittals.tranche', 1);
                })
                ->limit($batchSize)
                ->delete();

            $firstTrancheDeleted += $deleted;

            if ($deleted > 0) {
                sleep(1); // Optional: Add a delay to reduce contention
            }
        } while ($deleted > 0);

        // Delete records for the second tranche in batches
        do {
            $deleted = DB::table('konsulta_transmittals')
                ->where('tranche', 2)
                ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('consults')
                        ->whereRaw('consults.transmittal_number = konsulta_transmittals.transmittal_number')
                        ->where('konsulta_transmittals.tranche', 2);
                })
                ->limit($batchSize)
                ->delete();

            $secondTrancheDeleted += $deleted;

            if ($deleted > 0) {
                sleep(1); // Optional: Add a delay to reduce contention
            }
        } while ($deleted > 0);

        // Calculate total records deleted
        $totalDeleted = $firstTrancheDeleted + $secondTrancheDeleted;

        // Prepare the message
        if ($totalDeleted > 0) {
            $message = "Total records deleted: $totalDeleted\n";
            $message .= "First tranche total deleted: $firstTrancheDeleted\n";
            $message .= "Second tranche total deleted: $secondTrancheDeleted";
        } else {
            $message = "No records deleted.";
        }

        // Output the message
        $this->info($message);
    }
}
