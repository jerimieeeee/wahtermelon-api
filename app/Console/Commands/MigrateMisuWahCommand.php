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
use Symfony\Component\Console\Helper\ProgressBar;

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
        $database = $this->choice(
            'Select database to be migrated:',
            $databaseNames
        );
        $connectionName = 'mysql_migration';
        $this->migrationConnection($connectionName, $database);
        //echo $this->migrateUser()->collect()->chunk(200)->count();
        $users = $this->migrateUser();
        $bar = $this->output->createProgressBar(count($users));

        $bar->start();
        $users->collect()->chunk(200)->each(function ($user) use($connectionName, $database, $bar){
            $values = [];
            //$updateColumns = ['value']; // Define the columns to update if a conflict occurs
            //DB::purge($connectionName);
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
                    $record + ['password' => Str::password(8), 'facility_code' => $database]);
                //$user->update(['wahtermelon_user_id' => $newUser->id]);
                //Update the misuwah user database with wahtermelon_user_id from wahtermelon database
                DB::connection($connectionName)->table('user')->whereId($record['id'])->update(['wahtermelon_user_id' => $newUser->id]);
                //$this->components->twoColumnDetail($record['id'], $newUser->id);
                //echo DB::table('user')->get();
                $bar->advance();
            }
            echo Str::password(8);

            //$model->upsert($values, ['custom_id']);
        });

        $bar->finish();

        $patients = $this->migratePatient();
        $this->info("Creating progress bar...\n");
        $bar = $this->output->createProgressBar(count($patients));
        //$bar->setFormat("%message%\n %current%/%max% [%bar%] %percent:3s%%");
        $bar->setFormatDefinition('custom', '%countdown% [%bar%]');
        $bar->setFormat('custom');
        $bar->setPlaceholderFormatter('countdown', function (ProgressBar $progressBar) {
            return $progressBar->getMaxSteps() - $progressBar->getProgress();
        });
        //$bar->setMessage("100? I won't count all that!");
        //$bar->setProgress(0);
        $bar->start();
        $patients->collect()->chunk(200)->each(function ($patient, $chunkNumber) use($connectionName, $database, $bar){
            $values = [];
            //$updateColumns = ['value']; // Define the columns to update if a conflict occurs
            //DB::purge($connectionName);
            $startIndex = $chunkNumber * 200 + 1;
            $endIndex = min($startIndex + $patient->count() - 1, $startIndex + 200 - 1);

            $bar->setMessage("Processing chunk range: $startIndex - $endIndex");

            foreach ($patient as $record) {
                //echo $values[] = $record;
                //dd((array) $record);
                $record = (array) $record;
//                if(!$record['employer_code']){
//                    Arr::pull($record, 'employer_code');
//                }
                if(!$record['education_code']){
                    Arr::pull($record, 'education_code');
                }
                if(!$record['religion_code']){
                    Arr::pull($record, 'religion_code');
                }
                if(!$record['occupation_code']){
                    Arr::pull($record, 'occupation_code');
                }
                if(!$record['civil_status_code']){
                    Arr::pull($record, 'civil_status_code');
                }
                $newUser = Patient::updateOrCreate([
                    'last_name' => $record['last_name'],
                    'first_name' => $record['first_name'],
                    'middle_name' => $record['middle_name'],
                    'suffix_name' => $record['suffix_name'],
                    'birthdate' => $record['birthdate']
                ],
                    $record + ['facility_code' => $database]);
                //$user->update(['wahtermelon_user_id' => $newUser->id]);
                //Update the misuwah user database with wahtermelon_user_id from wahtermelon database
                //DB::connection($connectionName)->table('user')->whereId($record['id'])->update(['wahtermelon_user_id' => $newUser->id]);
                //$this->components->twoColumnDetail($record['id'], $newUser->id);
                //echo DB::table('user')->get();
                $bar->advance();
            }

            //echo $key;
            //$model->upsert($values, ['custom_id']);
        });
        $bar->setMessage("Migrated!");
        $bar->finish();
    }

    public function migrationConnection($connectionName, $database)
    {
        //$connectionName = 'mysql_migration'; // Replace with the name of your database connection
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
    }

    public function migrateUser()
    {
        return DB::connection('mysql_migration')->table('user')->selectRaw('
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
            ->whereNull('wahtermelon_user_id')
            ->get();
    }
    public function migratePatient()
    {
        return DB::connection('mysql_migration')->table('patient')
            ->selectRaw('
                patient.id AS id,
                wahtermelon_user_id AS user_id,
                patient.last_name,
                patient.first_name,
                patient.middle_name,
                CASE
                    WHEN patient.suffix_name = "NOTAP"
                    THEN "NA"
                    WHEN patient.suffix_name IS NULL OR patient.suffix_name = ""
                    THEN "NA"
                    ELSE patient.suffix_name
                END suffix_name,
                patient.birthdate,
                patient.gender,
                patient.mobile_number,
                mothers_name,
                CASE
                    WHEN pwd_flag = "Y"
                    THEN "UN"
                    ELSE "NA"
                END pwd_type_code,
                CASE
                    WHEN ind_flag = "Y"
                    THEN 1
                    ELSE 0
                END indegenous_flag,
                blood_type AS blood_type_code,
                religion_id AS religion_code,
                civil_status_id AS civil_status_code,
                CASE
                    WHEN education_id = "99"
                    THEN 8
                    ELSE education_id
                END education_code,
                occup_id AS occupation_code,
                CASE
                    WHEN consent_flag = "Y"
                    THEN 1
                    ELSE 0
                END consent_flag,
                patient.created_at,
                patient.updated_at
            ')
            ->join('user', function ($join) {
                $join->on('patient.user_id', '=', 'user.id')
                    ->select('id', 'wahtermelon_user_id');
            })
            ->whereDate('patient.birthdate', '>', '0000-00-00')
            ->whereDay('patient.birthdate', '!=', 0)
            ->whereMonth('patient.birthdate', '!=', 0)
            ->whereYear('patient.birthdate', '!=', 0)
            ->whereNotNull('patient.gender')
            ->where(function ($query) {
                $query->where('patient.mobile_number', 'REGEXP', '^0[1-9][0-9]{8}$')
                    ->orWhere('patient.mobile_number', 'REGEXP', '^9[0-9]{9}$');
            })
            ->get();
    }
}
