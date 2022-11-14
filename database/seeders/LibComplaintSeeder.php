<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibComplaint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LibComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibComplaint::upsert([
          ['complaint_id' => 'ABDPAIN', 'complaint_desc' => 'Abdominal Pain', 'complaint_active' => 1],
          ['complaint_id' => 'ABSCESS', 'complaint_desc' => 'Abscess Formation', 'complaint_active' => 1],
          ['complaint_id' => 'AME', 'complaint_desc' => 'Amenorrhea', 'complaint_active' => 1],
          ['complaint_id' => 'ANRXIA', 'complaint_desc' => 'Anorexia', 'complaint_active' => 1],
          ['complaint_id' => 'AN_PE', 'complaint_desc' => 'Annual PE', 'complaint_active' => 1],
          ['complaint_id' => 'BACKP', 'complaint_desc' => 'Back Pain', 'complaint_active' => 1],
          ['complaint_id' => 'BITES', 'complaint_desc' => 'Dog Bites', 'complaint_active' => 1],
          ['complaint_id' => 'BODY PAIN', 'complaint_desc' => 'Body pain', 'complaint_active' => 1],
          ['complaint_id' => 'BOV', 'complaint_desc' => 'Blurring of vision', 'complaint_active' => 1],
          ['complaint_id' => 'CATBITES', 'complaint_desc' => 'Cat Bites', 'complaint_active' => 0],
          ['complaint_id' => 'CHESTP', 'complaint_desc' => 'Chest Pain', 'complaint_active' => 1],
          ['complaint_id' => 'CHESTT', 'complaint_desc' => 'Chest tightness', 'complaint_active' => 1],
          ['complaint_id' => 'CHLDESS', 'complaint_desc' => 'childless', 'complaint_active' => 0],
          ['complaint_id' => 'CHOLIC', 'complaint_desc' => 'Colic', 'complaint_active' => 1],
          ['complaint_id' => 'CHRON WOUN', 'complaint_desc' => 'Chronic wound', 'complaint_active' => 0],
          ['complaint_id' => 'COLDS', 'complaint_desc' => 'Colds', 'complaint_active' => 1],
          ['complaint_id' => 'CONV', 'complaint_desc' => 'Convulsions', 'complaint_active' => 1],
          ['complaint_id' => 'COUGH', 'complaint_desc' => 'Cough', 'complaint_active' => 1],
          ['complaint_id' => 'DEAF', 'complaint_desc' => 'Deafness', 'complaint_active' => 1],
          ['complaint_id' => 'DIA', 'complaint_desc' => 'Diarrhea', 'complaint_active' => 1],
          ['complaint_id' => 'DIFFSLEEP', 'complaint_desc' => 'Difficulty sleeping', 'complaint_active' => 1],
          ['complaint_id' => 'DIFFSWL', 'complaint_desc' => 'Diff. of swallowing', 'complaint_active' => 1],
          ['complaint_id' => 'DIZZ', 'complaint_desc' => 'Dizziness', 'complaint_active' => 1],
          ['complaint_id' => 'DOB', 'complaint_desc' => 'Diff. of Breathing', 'complaint_active' => 1],
          ['complaint_id' => 'dssm', 'complaint_desc' => 'for DSSM', 'complaint_active' => 1],
          ['complaint_id' => 'DYSMEN', 'complaint_desc' => 'Dysmenorrhea', 'complaint_active' => 1],
          ['complaint_id' => 'DYSURIA', 'complaint_desc' => 'Dysuria', 'complaint_active' => 1],
          ['complaint_id' => 'EARDCHG', 'complaint_desc' => 'Ear Discharge', 'complaint_active' => 1],
          ['complaint_id' => 'EARPAIN', 'complaint_desc' => 'Ear Pain', 'complaint_active' => 1],
          ['complaint_id' => 'EDE', 'complaint_desc' => 'Edema', 'complaint_active' => 1],
          ['complaint_id' => 'ENLRG ABDO', 'complaint_desc' => 'enlarged abdomen', 'complaint_active' => 1],
          ['complaint_id' => 'EPI', 'complaint_desc' => 'Epigastric pain', 'complaint_active' => 1],
          ['complaint_id' => 'EYE REDNES', 'complaint_desc' => 'Redness of the eye', 'complaint_active' => 1],
          ['complaint_id' => 'EYEDISCHAR', 'complaint_desc' => 'Eye Discharge', 'complaint_active' => 1],
          ['complaint_id' => 'Eye_p', 'complaint_desc' => 'eye pain', 'complaint_active' => 1],
          ['complaint_id' => 'FB', 'complaint_desc' => 'Foreign Body', 'complaint_active' => 1],
          ['complaint_id' => 'FEVER', 'complaint_desc' => 'Fever', 'complaint_active' => 1],
          ['complaint_id' => 'ff-up', 'complaint_desc' => 'follow- up UA', 'complaint_active' => 0],
          ['complaint_id' => 'ffupcheck', 'complaint_desc' => 'follow up check up', 'complaint_active' => 0],
          ['complaint_id' => 'ffupwlabs', 'complaint_desc' => 'ffup with lab report', 'complaint_active' => 0],
          ['complaint_id' => 'FLATUS', 'complaint_desc' => 'Flatulence', 'complaint_active' => 1],
          ['complaint_id' => 'follow-up', 'complaint_desc' => 'Follow-up Hgb', 'complaint_active' => 0],
          ['complaint_id' => 'FP', 'complaint_desc' => 'Family Planning', 'complaint_active' => 0],
          ['complaint_id' => 'FRGD', 'complaint_desc' => 'Frigid', 'complaint_active' => 1],
          ['complaint_id' => 'FW-UP', 'complaint_desc' => 'follow-up', 'complaint_active' => 1],
          ['complaint_id' => 'HACHE', 'complaint_desc' => 'Headache', 'complaint_active' => 1],
          ['complaint_id' => 'HEMOP', 'complaint_desc' => 'Hemoptysis', 'complaint_active' => 1],
          ['complaint_id' => 'HYPOPAIN', 'complaint_desc' => 'Hypogastric Pain', 'complaint_active' => 1],
          ['complaint_id' => 'ICT', 'complaint_desc' => 'Icterisia', 'complaint_active' => 0],
          ['complaint_id' => 'INJURY', 'complaint_desc' => 'Injury', 'complaint_active' => 1],
          ['complaint_id' => 'INSCD WOUN', 'complaint_desc' => 'Incised wound', 'complaint_active' => 0],
          ['complaint_id' => 'ITCHE', 'complaint_desc' => 'Itchiness', 'complaint_active' => 1],
          ['complaint_id' => 'Jaundice', 'complaint_desc' => 'Jaundice', 'complaint_active' => 1],
          ['complaint_id' => 'JELLy STIN', 'complaint_desc' => 'Jelly Fish Sting', 'complaint_active' => 0],
          ['complaint_id' => 'JOINTP', 'complaint_desc' => 'Joint pain', 'complaint_active' => 1],
          ['complaint_id' => 'KNEE PN', 'complaint_desc' => 'Knee pain', 'complaint_active' => 1],
          ['complaint_id' => 'L WKNSS', 'complaint_desc' => 'Left Sided Weakness', 'complaint_active' => 0],
          ['complaint_id' => 'LBM', 'complaint_desc' => 'Loose bowel movement', 'complaint_active' => 1],
          ['complaint_id' => 'LESION', 'complaint_desc' => 'Lesion', 'complaint_active' => 1],
          ['complaint_id' => 'LOC', 'complaint_desc' => 'Loss Of Consciousnes', 'complaint_active' => 1],
          ['complaint_id' => 'LOSS APP', 'complaint_desc' => 'Loss of Appitite', 'complaint_active' => 1],
          ['complaint_id' => 'LOWERBACKP', 'complaint_desc' => 'Lower Back Pain', 'complaint_active' => 1],
          ['complaint_id' => 'M WOUND', 'complaint_desc' => 'Macerated Wound', 'complaint_active' => 0],
          ['complaint_id' => 'MASS', 'complaint_desc' => 'Mass/Tumor', 'complaint_active' => 1],
          ['complaint_id' => 'medcert', 'complaint_desc' => 'For Med Certification', 'complaint_active' => 1],
          ['complaint_id' => 'Medico-leg', 'complaint_desc' => 'For Medico-legal', 'complaint_active' => 1],
          ['complaint_id' => 'NAIL DOS', 'complaint_desc' => 'Nail Discoloration', 'complaint_active' => 1],
          ['complaint_id' => 'NAPE PAIN', 'complaint_desc' => 'Nape Pain', 'complaint_active' => 1],
          ['complaint_id' => 'NOSE BLEE', 'complaint_desc' => 'Nose Bleeding', 'complaint_active' => 1],
          ['complaint_id' => 'NUMB', 'complaint_desc' => 'Numbness', 'complaint_active' => 1],
          ['complaint_id' => 'ORLTSH', 'complaint_desc' => 'Oral Trush', 'complaint_active' => 1],
          ['complaint_id' => 'PNL DC', 'complaint_desc' => 'Penile Discharge', 'complaint_active' => 1],
          ['complaint_id' => 'POLYURIA', 'complaint_desc' => 'Polyuria', 'complaint_active' => 1],
          ['complaint_id' => 'POOR MEM', 'complaint_desc' => 'Poor Memory', 'complaint_active' => 1],
          ['complaint_id' => 'Prenatal', 'complaint_desc' => 'For Prenatal', 'complaint_active' => 0],
          ['complaint_id' => 'PRURITUS', 'complaint_desc' => 'Pruritus', 'complaint_active' => 1],
          ['complaint_id' => 'PUNCWND', 'complaint_desc' => 'Punctured Wound', 'complaint_active' => 0],
          ['complaint_id' => 'R WKNSS', 'complaint_desc' => 'Right Sided Weakness', 'complaint_active' => 0],
          ['complaint_id' => 'RASH', 'complaint_desc' => 'Rashes', 'complaint_active' => 1],
          ['complaint_id' => 'RATBITES', 'complaint_desc' => 'Rat Bites', 'complaint_active' => 0],
          ['complaint_id' => 'SACRO LUMB', 'complaint_desc' => 'Sacro Lumbar Pain', 'complaint_active' => 0],
          ['complaint_id' => 'SFTSTL', 'complaint_desc' => 'Soft Stool', 'complaint_active' => 0],
          ['complaint_id' => 'STHROAT', 'complaint_desc' => 'Sore Throat', 'complaint_active' => 1],
          ['complaint_id' => 'tnts', 'complaint_desc' => 'Tinnitus', 'complaint_active' => 1],
          ['complaint_id' => 'URETH DCG', 'complaint_desc' => 'Urethral Discharge', 'complaint_active' => 1],
          ['complaint_id' => 'V ACCDNT', 'complaint_desc' => 'Vehicular Accident', 'complaint_active' => 1],
          ['complaint_id' => 'VAG DCG', 'complaint_desc' => 'Vaginal Discharge', 'complaint_active' => 1],
          ['complaint_id' => 'VAGBLEED', 'complaint_desc' => 'Vaginal Bleeding', 'complaint_active' => 1],
          ['complaint_id' => 'VOMIT', 'complaint_desc' => 'Vomiting', 'complaint_active' => 1],
          ['complaint_id' => 'WGHT LOSS', 'complaint_desc' => 'Weight Loss', 'complaint_active' => 1],
          ['complaint_id' => 'WKNSS', 'complaint_desc' => 'Weakness', 'complaint_active' => 1],
          ['complaint_id' => 'WND', 'complaint_desc' => 'Lacerated Wound', 'complaint_active' => 0],
          ['complaint_id' => 'WOUND', 'complaint_desc' => 'Wound', 'complaint_active' => 1],
          ['complaint_id' => 'WTRY STOOL', 'complaint_desc' => 'Watery Stool', 'complaint_active' => 0]
        ], ['complaint_id']);
    }
}
