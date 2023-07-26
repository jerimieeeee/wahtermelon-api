<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\V1\Household\HouseholdFolder;
use App\Models\V1\Household\HouseholdMember;
use App\Models\V1\Konsulta\KonsultaRegistrationList;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientPhilhealth;
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
        $userBar = $this->output->createProgressBar(count($users));
        $userBar->setFormat('Processing User Table: %current%/%max% [%bar%] %percent:3s%%');
        $userBar->start();
        $users->collect()->chunk(200)->each(function ($user) use($connectionName, $database, $userBar){
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
                $userBar->advance();
            }
            //$model->upsert($values, ['custom_id']);
        });
        $userBar->finish();
        $this->newLine();
        $this->components->twoColumnDetail('User Migration', 'Done');
        $this->newLine();

        $patients = $this->migratePatient();
        //$this->info("Creating progress bar...\n");
        $patientBar = $this->output->createProgressBar(count($patients));
        $patientBar->setFormat('Processing Patient Table: %current%/%max% [%bar%] %percent:3s%%');
        //$bar->setMessage("100? I won't count all that!");
        //$bar->setProgress(0);
        $patientBar->start();
        $patients->collect()->chunk(200)->each(function ($patient, $chunkNumber) use($connectionName, $database, $patientBar){
            $values = [];
            //$updateColumns = ['value']; // Define the columns to update if a conflict occurs
            //DB::purge($connectionName);
//            $startIndex = $chunkNumber * 200 + 1;
//            $endIndex = min($startIndex + $patient->count() - 1, $startIndex + 200 - 1);
//
//            $bar->setMessage("Processing chunk range: $startIndex - $endIndex");

            foreach ($patient as $record) {
                //echo $values[] = $record;
                //dd((array) $record);
                $record = (array) $record;
//                if(!$record['employer_code']){
//                    Arr::pull($record, 'employer_code');
//                }
                if(!$record['mobile_number']){
                    Arr::pull($record, 'mobile_number');
                }
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
                DB::connection($connectionName)->table('patient')->whereId($record['id'])->update(['wahtermelon_patient_id' => $newUser->id]);
                //$this->components->twoColumnDetail($record['id'], $newUser->id);
                //echo DB::table('user')->get();
                $patientBar->advance();
            }

            //echo $key;
            //$model->upsert($values, ['custom_id']);
        });
        $patientBar->finish();
        $this->newLine();
        $this->components->twoColumnDetail('Patient Migration', 'Done');
        $this->newLine();

        $household = $this->migrateHousehold();
        $householdBar = $this->output->createProgressBar(count($household));
        $householdBar->setFormat('Processing Household Table: %current%/%max% [%bar%] %percent:3s%%');
        //$bar->setMessage("100? I won't count all that!");
        //$bar->setProgress(0);
        $householdBar->start();
        $household->collect()->chunk(200)->each(function ($household, $chunkNumber) use($connectionName, $database, $householdBar){
            $values = [];
            //$updateColumns = ['value']; // Define the columns to update if a conflict occurs
            //DB::purge($connectionName);
//            $startIndex = $chunkNumber * 200 + 1;
//            $endIndex = min($startIndex + $patient->count() - 1, $startIndex + 200 - 1);
//
//            $bar->setMessage("Processing chunk range: $startIndex - $endIndex");

            foreach ($household as $record) {
                //echo $values[] = $record;
                //dd((array) $record);
                $record = (array) $record;
//                if(!$record['employer_code']){
//                    Arr::pull($record, 'employer_code');
//                }
                $roles = array_map('strtoupper', explode(',', $record['roles']));
                $patients = explode(',', $record['patients']);
                $users = explode(',', $record['users']);
                $last_names = explode(',', $record['last_names']);
                $first_names = explode(',', $record['first_names']);
                $middle_names = explode(',', $record['middle_names']);
                $suffix_names = explode(',', $record['suffix_names']);
                $birthdates = explode(',', $record['birthdates']);

                $resultArray = array_map(function ($patient_id, $user_id, $family_role_code) {
                    return compact('patient_id', 'user_id', 'family_role_code');
                }, $patients, $users, $roles);

                $patient_info = array_map(function ($last_name, $first_name, $middle_name, $suffix_name, $birthdate) {
                    return compact('last_name', 'first_name', 'middle_name', 'suffix_name', 'birthdate');
                }, $last_names, $first_names, $middle_names, $suffix_names, $birthdates);

                /*$newUser = HouseholdFolder::updateOrCreate([
                    'last_name' => $record['last_name'],
                    'first_name' => $record['first_name'],
                    'middle_name' => $record['middle_name'],
                    'suffix_name' => $record['suffix_name'],
                    'birthdate' => $record['birthdate']
                ],
                    $record + ['facility_code' => $database]);
                //Update the misuwah family database with wahtermelon_family_id from wahtermelon database
                DB::connection($connectionName)->table('family')->whereId($record['id'])->update(['wahtermelon_family_id' => $newUser->id]);*/
                //$this->components->twoColumnDetail($record['id'], $newUser->id);
                //echo DB::table('user')->get();
                DB::transaction(function() use($connectionName, $database, $record, $resultArray, $patient_info) {
                    //echo $users[0];
                    //print_r($record);
                    $data = [
                        'user_id' => $resultArray[0]['user_id'],
                        'facility_code' => $database,
                        'address' => $record['address'],
                        'barangay_code' => $record['brgy_code'],
                        'cct_date' => $record['cct_membership'],
                        'cct_id' => $record['cct_id']
                    ];

                    $householdId = '';
                    foreach($patient_info as $value){
                        $patient = Patient::query()
                            ->where('last_name', $value['last_name'])->where('first_name', $value['first_name'])->where('middle_name', $value['middle_name'])->where('suffix_name', $value['suffix_name'])->where('birthdate', $value['birthdate'])
                            ->first();
                        if(!empty($patient) && !empty($patient->householdMember)){
                            $householdId = $patient->householdMember->household_folder_id;
                            break;
                        }
                    }

                    if(empty($householdId)){
                        $newHousehold = HouseholdFolder::create($data);
                        $householdId = $newHousehold->id;
                    }

                    $resultArray = array_map(function ($item) use($householdId) {
                        return array_merge($item, ['household_folder_id' => $householdId]);
                    }, $resultArray);
                    //dd(array_values($resultArray));
                    HouseholdMember::upsert(array_values($resultArray), ['household_folder_id', 'patient_id', 'user_id', ]);
                    DB::connection($connectionName)->table('family')->whereId($record['id'])->update(['wahtermelon_family_id' => $householdId]);
                });

                $householdBar->advance();
            }

            //echo $key;
            //$model->upsert($values, ['custom_id']);
        });
        $householdBar->finish();
        $this->newLine();
        $this->components->twoColumnDetail('Household Migration', 'Done');
        $this->newLine();

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
            Schema::connection($connectionName)->table('family', function (Blueprint $table) {
                $table->string('wahtermelon_family_id')->nullable()->after('id');
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
                CASE
                    WHEN (patient.mobile_number REGEXP "^(0[1-9][0-9]{8})|(9[0-9]{9})$")
                    THEN patient.mobile_number
                    WHEN (patient.mobile_number REGEXP "^0+$|^9+$|^0[0-9]{9}$|^9[0-9]{9}$")
                    THEN NULL
                    ELSE NULL
                END mobile_number,
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
            ->where('patient.gender', '!=', '')
//            ->where(function ($query) {
//                $query->where('patient.mobile_number', 'REGEXP', '^0[1-9][0-9]{8}$')
//                    ->orWhere('patient.mobile_number', 'REGEXP', '^9[0-9]{9}$');
//            })
            ->whereNull('wahtermelon_patient_id')
            ->get();
    }

    public function migrateHousehold()
    {
        DB::connection('mysql_migration')->statement('SET group_concat_max_len = 10000');
        return DB::connection('mysql_migration')->table('family')
            //->join('patient', 'patient.id', '=', 'family_members.patient_id')
            ->selectRaw('
                family.*,
                GROUP_CONCAT(family_members.role ORDER BY family_members.patient_id ASC) AS roles,
                GROUP_CONCAT(patient.wahtermelon_patient_id ORDER BY patient.id ASC) AS patients,
                GROUP_CONCAT(user.wahtermelon_user_id ORDER BY patient.id ASC) AS users,
                GROUP_CONCAT(patient.last_name ORDER BY patient.id ASC) AS last_names,
                GROUP_CONCAT(patient.first_name ORDER BY patient.id ASC) AS first_names,
                GROUP_CONCAT(patient.middle_name ORDER BY patient.id ASC) AS middle_names,
                GROUP_CONCAT(CASE
                    WHEN patient.suffix_name = "NOTAP"
                    THEN "NA"
                    WHEN patient.suffix_name IS NULL OR patient.suffix_name = ""
                    THEN "NA"
                    ELSE patient.suffix_name
                END ORDER BY patient.id ASC) AS suffix_names,
                GROUP_CONCAT(patient.birthdate ORDER BY patient.id ASC) AS birthdates
            ')
            ->join('family_members', 'family_members.family_id', '=', 'family.id')
            ->join('patient', function ($join) {
                $join->on('patient.id', '=', 'family_members.patient_id')
                    ->whereNotNull('wahtermelon_patient_id');
            })
            //->join('user', 'user.id', '=', 'patient.user_id')
            ->join('user', function ($join) {
                $join->on('user.id', '=', 'patient.user_id')
                    ->whereNotNull('wahtermelon_user_id');
            })
            //->whereNull('wahtermelon_family_id')
            ->groupBy('family.id')
            ->get();
    }
}
