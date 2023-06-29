<?php

namespace App\Console\Commands;

use App\Models\V1\Patient\Patient;
use Illuminate\Console\Command;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateMisuWahCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'misuwah:migrate';

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
        $databases = DB::select("SHOW DATABASES LIKE 'victoria%'");
        $databaseNames = array_map('current', $databases);
        foreach ($databaseNames as $database) {
            //$databaseName = $database->Database;
            echo $database;
            $connectionName = 'mysql'; // Replace with the name of your database connection
            $newDatabaseName = $database; // Replace with the new database name you want to use

            DB::purge($connectionName); // Clear any previous configurations for the connection

// Retrieve the database connection configuration array
            $config = config("database.connections.$connectionName");

// Update the 'database' parameter with the new database name
            $config['database'] = $newDatabaseName;

// Set the updated configuration for the connection
            $connection = app(ConnectionFactory::class)->make($config);

// Set the new connection instance for the specific connection name
            DB::connection($connectionName)->setPdo($connection->getPdo())->setReadPdo($connection->getReadPdo());
            // Add column if it doesn't exist on the 'patient' table
            // Add column if it doesn't exist on the 'patient' table
            try {
                // Add column if it doesn't exist on the 'patient' table
                Schema::connection($connectionName)->table('patient', function (Blueprint $table) {
                    $table->string('wahtermelon_patient_id')->nullable()->after('id');
                    // Add more columns if needed
                });
                Schema::connection($connectionName)->table('user', function (Blueprint $table) {
                    $table->string('wahtermelon_user_id')->nullable()->after('id');
                    // Add more columns if needed
                });
            } catch (\Exception $e) {
                // Handle the exception (column already exists)
                // You can log the error or perform other actions if needed
                // For now, we'll just skip this iteration
                //continue;
            }

            //$results = DB::connection($connectionName)->table('your_table')->select('*')->get();

            //$results = DB::connection($connectionName)->table('patient')->select('*')->whereNull('wahtermelon_patient_id')->get();
            //$results = DB::connection($connectionName)->table('user')->select('*')->get();
            $results = DB::table('user')->select('*')->get();
            // Perform your operations on each matching database here
            // ...
            DB::purge($connectionName);
            //Patient::query()->get();
            echo $results;
        }
    }
}
