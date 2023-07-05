<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\V1\Patient\Patient;
use Illuminate\Console\Command;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

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
        $databases = DB::select("SHOW DATABASES LIKE 'DOH%'");
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
            $misuwahUsers = DB::table('user')->selectRaw('
                    id,
                    last_name,
                    first_name,
                    middle_name,
                    CASE
                        WHEN suffix_name = "NOTAP"
                        THEN "NA"
                        WHEN suffix_name IS NULL OR suffix_name = ""
                        THEN "NA"
                        ELSE suffix_name
                    END suffix_name,
                    birthdate,
                    gender,
                    email,
                    mobile_number AS contact_number,
                    CASE
                        WHEN is_active = "Y"
                        THEN 1
                        ELSE 0
                    END is_active,
                    designation AS designation_code,
                    employer AS employer_code,
                    tin_number,
                    accreditation_number,
                    created_at,
                    updated_at
                ')
                ->where('email', '!=', '')
                ->get()->collect()->chunk(200);
            // Perform your operations on each matching database here
            // ...
            DB::purge($connectionName);
            //Patient::query()->get();
            $misuwahUsers->each(function ($user) use($connectionName, $newDatabaseName){
                $values = [];
                //$updateColumns = ['value']; // Define the columns to update if a conflict occurs
                DB::purge($connectionName);
                foreach ($user as $record) {
                    //echo $values[] = $record;
                    //dd((array) $record);
                    $record = (array) $record;
                    if(!$record['employer_code']){
                        Arr::pull($record, 'employer_code');
                    }
                    $newUser = User::updateOrCreate([
                        'last_name' => $record['last_name'],
                        'first_name' => $record['first_name'],
                        'middle_name' => $record['middle_name'],
                        'suffix_name' => $record['suffix_name'],
                        'email' => $record['email']
                    ],
                        $record + ['password' => Str::password(8), 'facility_code' => $newDatabaseName]);
                    //$user->update(['wahtermelon_user_id' => $newUser->id]);
                }


                //$model->upsert($values, ['custom_id']);
            });;
        }
    }
}
