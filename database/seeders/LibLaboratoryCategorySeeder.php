<?php

namespace Database\Seeders;

use App\Models\V1\Libraries\LibLaboratoryCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LibLaboratoryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LibLaboratoryCategory::truncate();
        LibLaboratoryCategory::upsert([
            ['lab_code' => 'CBC', 'field_name' => 'hemoglobin', 'field_desc' => 'Hemoglobin', 'group_cat' => null, 'range_cat' => 'M', 'nv_min' => '13.5', 'nv_max' => '17.5', 'nv_uom' => 'g/dL', 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'hemoglobin', 'field_desc' => 'Hemoglobin', 'group_cat' => null, 'range_cat' => 'F', 'nv_min' => '12.0', 'nv_max' => '16.0', 'nv_uom' => 'g/dL', 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'hemoglobin', 'field_desc' => 'Hemoglobin', 'group_cat' => null, 'range_cat' => 'NB', 'nv_min' => '14.0', 'nv_max' => '20.0', 'nv_uom' => 'g/dL', 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'hematocrit', 'field_desc' => 'Hematocrit', 'group_cat' => null, 'range_cat' => 'M', 'nv_min' => '41', 'nv_max' => '53', 'nv_uom' => '%', 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'hematocrit', 'field_desc' => 'Hematocrit', 'group_cat' => null, 'range_cat' => 'F', 'nv_min' => '36', 'nv_max' => '46', 'nv_uom' => '%', 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'hematocrit', 'field_desc' => 'Hematocrit', 'group_cat' => null, 'range_cat' => 'NB', 'nv_min' => '49', 'nv_max' => '61', 'nv_uom' => '%', 'sequence_id' => '6', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'rbc', 'field_desc' => 'RBC Count', 'group_cat' => null, 'range_cat' => 'M', 'nv_min' => '4.3', 'nv_max' => '5.9', 'nv_uom' => 'mill/mm3', 'sequence_id' => '7', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'rbc', 'field_desc' => 'RBC Count', 'group_cat' => null, 'range_cat' => 'F', 'nv_min' => '3.5', 'nv_max' => '5.5', 'nv_uom' => 'mill/mm3', 'sequence_id' => '8', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'mcv', 'field_desc' => 'MCV', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '80', 'nv_max' => '100', 'nv_uom' => 'fl', 'sequence_id' => '9', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'mch', 'field_desc' => 'MCH', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '25.4', 'nv_max' => '34.6', 'nv_uom' => 'pg/cell', 'sequence_id' => '10', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'mchc', 'field_desc' => 'MCHC', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '31', 'nv_max' => '36', 'nv_uom' => 'Hb/cell', 'sequence_id' => '11', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'wbc', 'field_desc' => 'WBC Count', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '4,000', 'nv_max' => '12,000', 'nv_uom' => 'mm3', 'sequence_id' => '12', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'neutrophils', 'field_desc' => 'Neutrophils', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '54', 'nv_max' => '62', 'nv_uom' => '%', 'sequence_id' => '13', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'lymphocytes', 'field_desc' => 'Lymphocytes', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '25', 'nv_max' => '33', 'nv_uom' => '%', 'sequence_id' => '14', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'basophils', 'field_desc' => 'Basophils', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '0', 'nv_max' => '0.75', 'nv_uom' => '%', 'sequence_id' => '15', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'monocytes', 'field_desc' => 'Monocytes', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '3', 'nv_max' => '7', 'nv_uom' => '%', 'sequence_id' => '16', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'eosinophils', 'field_desc' => 'Eosinophils', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '1', 'nv_max' => '3', 'nv_uom' => '%', 'sequence_id' => '17', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'stab', 'field_desc' => 'Stab', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '2', 'nv_max' => '6', 'nv_uom' => '%', 'sequence_id' => '18', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'juvenile', 'field_desc' => 'Juvenile', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '0', 'nv_max' => '1', 'nv_uom' => '%', 'sequence_id' => '19', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'platelets', 'field_desc' => 'Platelets', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '150,000', 'nv_max' => '400,000', 'nv_uom' => 'mm3', 'sequence_id' => '20', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'reticulocytes', 'field_desc' => 'Reticulocytes', 'group_cat' => null, 'range_cat' => 'A', 'nv_min' => '0.5', 'nv_max' => '2.5', 'nv_uom' => '%', 'sequence_id' => '21', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'reticulocytes', 'field_desc' => 'Reticulocytes', 'group_cat' => null, 'range_cat' => 'NB', 'nv_min' => '2', 'nv_max' => '6', 'nv_uom' => '%', 'sequence_id' => '22', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'bleeding_time', 'field_desc' => 'Bleeding Time', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '1', 'nv_max' => '3', 'nv_uom' => 'min', 'sequence_id' => '23', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'clothing_time', 'field_desc' => 'Clothing Time', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '1', 'nv_max' => '6', 'nv_uom' => 'min', 'sequence_id' => '24', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'esr', 'field_desc' => 'ESR', 'group_cat' => null, 'range_cat' => 'M', 'nv_min' => '0', 'nv_max' => '15', 'nv_uom' => 'mm/hr', 'sequence_id' => '25', 'field_active' => 1],
            ['lab_code' => 'CBC', 'field_name' => 'esr', 'field_desc' => 'ESR', 'group_cat' => null, 'range_cat' => 'F', 'nv_min' => '0', 'nv_max' => '20', 'nv_uom' => 'mm/hr', 'sequence_id' => '26', 'field_active' => 1],

            ['lab_code' => 'HEMA', 'field_name' => 'hemoglobin', 'field_desc' => 'Hemoglobin', 'group_cat' => null, 'range_cat' => 'M', 'nv_min' => '13.5', 'nv_max' => '17.5', 'nv_uom' => 'g/dL', 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'hemoglobin', 'field_desc' => 'Hemoglobin', 'group_cat' => null, 'range_cat' => 'F', 'nv_min' => '12.0', 'nv_max' => '16.0', 'nv_uom' => 'g/dL', 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'hemoglobin', 'field_desc' => 'Hemoglobin', 'group_cat' => null, 'range_cat' => 'NB', 'nv_min' => '14.0', 'nv_max' => '20.0', 'nv_uom' => 'g/dL', 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'hematocrit', 'field_desc' => 'Hematocrit', 'group_cat' => null, 'range_cat' => 'M', 'nv_min' => '41', 'nv_max' => '53', 'nv_uom' => '%', 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'hematocrit', 'field_desc' => 'Hematocrit', 'group_cat' => null, 'range_cat' => 'F', 'nv_min' => '36', 'nv_max' => '46', 'nv_uom' => '%', 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'hematocrit', 'field_desc' => 'Hematocrit', 'group_cat' => null, 'range_cat' => 'NB', 'nv_min' => '49', 'nv_max' => '61', 'nv_uom' => '%', 'sequence_id' => '6', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'rbc', 'field_desc' => 'RBC Count', 'group_cat' => null, 'range_cat' => 'M', 'nv_min' => '4.3', 'nv_max' => '5.9', 'nv_uom' => 'mill/mm3', 'sequence_id' => '7', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'rbc', 'field_desc' => 'RBC Count', 'group_cat' => null, 'range_cat' => 'F', 'nv_min' => '3.5', 'nv_max' => '5.5', 'nv_uom' => 'mill/mm3', 'sequence_id' => '8', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'mcv', 'field_desc' => 'MCV', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '80', 'nv_max' => '100', 'nv_uom' => 'fl', 'sequence_id' => '9', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'mch', 'field_desc' => 'MCH', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '25.4', 'nv_max' => '34.6', 'nv_uom' => 'pg/cell', 'sequence_id' => '10', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'mchc', 'field_desc' => 'MCHC', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '31', 'nv_max' => '36', 'nv_uom' => 'Hb/cell', 'sequence_id' => '11', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'wbc', 'field_desc' => 'WBC Count', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '4,000', 'nv_max' => '12,000', 'nv_uom' => 'mm3', 'sequence_id' => '12', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'neutrophils', 'field_desc' => 'Neutrophils', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '54', 'nv_max' => '62', 'nv_uom' => '%', 'sequence_id' => '13', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'lymphocytes', 'field_desc' => 'Lymphocytes', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '25', 'nv_max' => '33', 'nv_uom' => '%', 'sequence_id' => '14', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'basophils', 'field_desc' => 'Basophils', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '0', 'nv_max' => '0.75', 'nv_uom' => '%', 'sequence_id' => '15', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'monocytes', 'field_desc' => 'Monocytes', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '3', 'nv_max' => '7', 'nv_uom' => '%', 'sequence_id' => '16', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'eosinophils', 'field_desc' => 'Eosinophils', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '1', 'nv_max' => '3', 'nv_uom' => '%', 'sequence_id' => '17', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'stab', 'field_desc' => 'Stab', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '2', 'nv_max' => '6', 'nv_uom' => '%', 'sequence_id' => '18', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'juvenile', 'field_desc' => 'Juvenile', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '0', 'nv_max' => '1', 'nv_uom' => '%', 'sequence_id' => '19', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'platelets', 'field_desc' => 'Platelets', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '150,000', 'nv_max' => '400,000', 'nv_uom' => 'mm3', 'sequence_id' => '20', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'reticulocytes', 'field_desc' => 'Reticulocytes', 'group_cat' => null, 'range_cat' => 'A', 'nv_min' => '0.5', 'nv_max' => '2.5', 'nv_uom' => '%', 'sequence_id' => '21', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'reticulocytes', 'field_desc' => 'Reticulocytes', 'group_cat' => null, 'range_cat' => 'NB', 'nv_min' => '2', 'nv_max' => '6', 'nv_uom' => '%', 'sequence_id' => '22', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'bleeding_time', 'field_desc' => 'Bleeding Time', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '1', 'nv_max' => '3', 'nv_uom' => 'min', 'sequence_id' => '23', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'clothing_time', 'field_desc' => 'Clothing Time', 'group_cat' => null, 'range_cat' => null, 'nv_min' => '1', 'nv_max' => '6', 'nv_uom' => 'min', 'sequence_id' => '24', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'esr', 'field_desc' => 'ESR', 'group_cat' => null, 'range_cat' => 'M', 'nv_min' => '0', 'nv_max' => '15', 'nv_uom' => 'mm/hr', 'sequence_id' => '25', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'esr', 'field_desc' => 'ESR', 'group_cat' => null, 'range_cat' => 'F', 'nv_min' => '0', 'nv_max' => '20', 'nv_uom' => 'mm/hr', 'sequence_id' => '26', 'field_active' => 1],
            ['lab_code' => 'HEMA', 'field_name' => 'blood_type', 'field_desc' => 'Blood Type', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '27', 'field_active' => 1],

            // ['lab_code' => 'URN', 'field_name' => 'color', 'field_desc' => 'Color', 'group_cat' => 'PHYSICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'transparency', 'field_desc' => 'Transparency', 'group_cat' => 'PHYSICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'sp_gravity', 'field_desc' => 'Specific Gravity', 'group_cat' => 'PHYSICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'ph', 'field_desc' => 'pH', 'group_cat' => 'PHYSICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],

            // ['lab_code' => 'URN', 'field_name' => 'reaction', 'field_desc' => 'Reaction', 'group_cat' => 'CHEMICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'protein', 'field_desc' => 'Protein', 'group_cat' => 'CHEMICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'glucose', 'field_desc' => 'Glucose', 'group_cat' => 'CHEMICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'ketones', 'field_desc' => 'Ketones', 'group_cat' => 'CHEMICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'blood', 'field_desc' => 'Blood(Hgb & MB)', 'group_cat' => 'CHEMICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'leukocyte', 'field_desc' => 'Leukocyte Esterase', 'group_cat' => 'CHEMICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'nitrite', 'field_desc' => 'Nitrite', 'group_cat' => 'CHEMICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '7', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'bilirubin', 'field_desc' => 'Bilirubin', 'group_cat' => 'CHEMICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '8', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'urobilinogen', 'field_desc' => 'Urobilinogen', 'group_cat' => 'CHEMICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '9', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'pregnancy_test', 'field_desc' => 'Pregnancy Test', 'group_cat' => 'CHEMICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '10', 'field_active' => 1],

            // ['lab_code' => 'URN', 'field_name' => 'rbc', 'field_desc' => 'Red Blood Cells', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'wbc', 'field_desc' => 'White Blood Cells', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'epithelial', 'field_desc' => 'Epithelial Cells', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'trichomonas', 'field_desc' => 'Trichomonas', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'urates', 'field_desc' => 'Urates', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'phospates', 'field_desc' => 'Phospates', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'calcium_oxelates', 'field_desc' => 'Calcium Oxelates', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '7', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'calcium_carbonates', 'field_desc' => 'Calcium Carbonates', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '8', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'fat_globules', 'field_desc' => 'Fat Globules', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '9', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'triple_phospates', 'field_desc' => 'Triple Phospates', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '10', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'mucus_threads', 'field_desc' => 'Mucus Threads', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '11', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'bacteria', 'field_desc' => 'Bacteria', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '12', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'crystals', 'field_desc' => 'Crystals', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '13', 'field_active' => 1],

            // ['lab_code' => 'URN', 'field_name' => 'granular', 'field_desc' => 'Granular Cast', 'group_cat' => 'CASTS', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'pus_cell', 'field_desc' => 'Pus Cell Cast', 'group_cat' => 'CASTS', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'red_cell', 'field_desc' => 'Red Cell Cast', 'group_cat' => 'CASTS', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'hyaline', 'field_desc' => 'Hyaline Cast', 'group_cat' => 'CASTS', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            // ['lab_code' => 'URN', 'field_name' => 'waxy', 'field_desc' => 'Waxy Cast', 'group_cat' => 'CASTS', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],


            ['lab_code' => 'URN', 'field_name' => 'gravity',         'field_desc' => 'Gravity',                    'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'appearance',      'field_desc' => 'Appearance',                 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'color',           'field_desc' => 'Color',                      'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'proteins',        'field_desc' => 'Protein',                    'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'ketones',         'field_desc' => 'ketones',                    'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'ph',              'field_desc' => 'PH',                         'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'rb_cells',        'field_desc' => 'Red Blood Cells',            'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'wb_cells',        'field_desc' => 'White Blood Cells',          'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '7', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'bacteria',        'field_desc' => 'Bacteria',                   'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '8', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'crystals',        'field_desc' => 'Crystals',                   'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '9', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'bladder_cells',   'field_desc' => 'Bladder Cells',              'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '10', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'squamous_cells',  'field_desc' => 'Squamous Cells',             'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '11', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'tubular_cells',   'field_desc' => 'Tubular Cells',              'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '12', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'broad_cast',      'field_desc' => 'Broad Cast',                 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '13', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'epithelial_cast', 'field_desc' => 'Epithelial Cell Casts',      'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '14', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'granular_cast',   'field_desc' => 'Granular Casts',             'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '15', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'hyaline_cast',    'field_desc' => 'Hyaline Casts',              'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '16', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'rbc_cast',        'field_desc' => 'RBC Casts',                  'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '17', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'waxy_cast',       'field_desc' => 'Waxy Casts',                 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '18', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'wc_cast',         'field_desc' => 'WC Casts',                   'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '18', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'albumin',         'field_desc' => 'Albumin',                    'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '19', 'field_active' => 1],
            ['lab_code' => 'URN', 'field_name' => 'pus_cells',       'field_desc' => 'PUS Cell',                   'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '20', 'field_active' => 1],

            ['lab_code' => 'FCAL', 'field_name' => 'color_code',       'field_desc' => 'Color',         'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'FCAL', 'field_name' => 'consistency_code', 'field_desc' => 'Consistency',   'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'FCAL', 'field_name' => 'rbc',              'field_desc' => 'RBC',           'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'FCAL', 'field_name' => 'wbc',              'field_desc' => 'WBC',           'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'FCAL', 'field_name' => 'ova',              'field_desc' => 'OVA',           'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'FCAL', 'field_name' => 'parasite',         'field_desc' => 'Parasite',      'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],
            ['lab_code' => 'FCAL', 'field_name' => 'pus_cells',        'field_desc' => 'PUS Cells',     'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '7', 'field_active' => 1],

            // ['lab_code' => 'FCAL', 'field_name' => 'color', 'field_desc' => 'Color', 'group_cat' => 'PHYSICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'concentration', 'field_desc' => 'Concentration', 'group_cat' => 'PHYSICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'consistency', 'field_desc' => 'Concistency', 'group_cat' => 'PHYSICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],

            // ['lab_code' => 'FCAL', 'field_name' => 'occult_blood', 'field_desc' => 'Occult Blood', 'group_cat' => 'CHEMICAL', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],

            // ['lab_code' => 'FCAL', 'field_name' => 'pus_cell', 'field_desc' => 'Pus Cells', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'red_cell', 'field_desc' => 'Red Cells', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'yeast_cell', 'field_desc' => 'Yeast Cells', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'bacteria', 'field_desc' => 'Bacteria', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'fat_globules', 'field_desc' => 'Fat Globules', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'ascaris_lumbricoides', 'field_desc' => 'Ascaris Lumbricoides', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'trichuris_trichuira', 'field_desc' => 'Trichuris Trichuira', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '7', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'stercoralis', 'field_desc' => 'S. Stercoralis', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '8', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'hookworm', 'field_desc' => 'Hookworm', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '9', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'e_histolytica', 'field_desc' => 'Entamoeba Histolytica', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '10', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'e_coli', 'field_desc' => 'Entamoeba Coli', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '11', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'flagellates', 'field_desc' => 'Flagellates', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '12', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'giardia_lamblia', 'field_desc' => 'Giardia Lamblia', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '13', 'field_active' => 1],
            // ['lab_code' => 'FCAL', 'field_name' => 'trichomonas_hominis', 'field_desc' => 'Trichomonas Hominis', 'group_cat' => 'MICROSCOPIC', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '14', 'field_active' => 1],

            ['lab_code' => 'BCHM', 'field_name' => 'bicarbonate', 'field_desc' => 'Bicarbonate', 'group_cat' => 'ELECTROLYTES', 'range_cat' => null, 'nv_min' => '18', 'nv_max' => '30', 'nv_uom' => 'mEq/L', 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'calcium', 'field_desc' => 'Calcium', 'group_cat' => 'ELECTROLYTES', 'range_cat' => null, 'nv_min' => '9', 'nv_max' => '11', 'nv_uom' => 'mg/dL', 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'chloride', 'field_desc' => 'Chloride', 'group_cat' => 'ELECTROLYTES', 'range_cat' => null, 'nv_min' => '98', 'nv_max' => '106', 'nv_uom' => 'mEq/L', 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'magnesium', 'field_desc' => 'Magnesium', 'group_cat' => 'ELECTROLYTES', 'range_cat' => null, 'nv_min' => '1.8', 'nv_max' => '3.6', 'nv_uom' => 'mg/dL', 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'phosphorus', 'field_desc' => 'Phosphorus', 'group_cat' => 'ELECTROLYTES', 'range_cat' => 'A', 'nv_min' => '3', 'nv_max' => '4.5', 'nv_uom' => 'mg/dL', 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'phosphorus', 'field_desc' => 'Phosphorus', 'group_cat' => 'ELECTROLYTES', 'range_cat' => 'C', 'nv_min' => '4', 'nv_max' => '6.5', 'nv_uom' => 'mg/dL', 'sequence_id' => '6', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'potassium', 'field_desc' => 'Potassium', 'group_cat' => 'ELECTROLYTES', 'range_cat' => null, 'nv_min' => '3.5', 'nv_max' => '5.5', 'nv_uom' => 'mg/dL', 'sequence_id' => '7', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'sodium', 'field_desc' => 'Sodium', 'group_cat' => 'ELECTROLYTES', 'range_cat' => null, 'nv_min' => '135', 'nv_max' => '147', 'nv_uom' => 'mEq/L', 'sequence_id' => '8', 'field_active' => 1],

            ['lab_code' => 'BCHM', 'field_name' => 'alkaline_phosphatase', 'field_desc' => 'Alkaline Phosphatase', 'group_cat' => 'ENZYMES', 'range_cat' => null, 'nv_min' => '50', 'nv_max' => '160', 'nv_uom' => 'U/L', 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'amylase', 'field_desc' => 'Amylase', 'group_cat' => 'ENZYMES', 'range_cat' => null, 'nv_min' => '53', 'nv_max' => '123', 'nv_uom' => 'U/L', 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'creatine_kinase', 'field_desc' => 'Creatine Kinase', 'group_cat' => 'ENZYMES', 'range_cat' => 'M', 'nv_min' => '38', 'nv_max' => '174', 'nv_uom' => 'U/L', 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'creatine_kinase', 'field_desc' => 'Creatine Kinase', 'group_cat' => 'ENZYMES', 'range_cat' => 'F', 'nv_min' => '96', 'nv_max' => '140', 'nv_uom' => 'U/L', 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'lipase', 'field_desc' => 'Lipase', 'group_cat' => 'ENZYMES', 'range_cat' => null, 'nv_min' => '10', 'nv_max' => '150', 'nv_uom' => 'U/L', 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'alt', 'field_desc' => 'ALT (GPT)', 'group_cat' => 'ENZYMES', 'range_cat' => null, 'nv_min' => '0', 'nv_max' => '30', 'nv_uom' => 'U/L', 'sequence_id' => '6', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'ast', 'field_desc' => 'AST (GOT)', 'group_cat' => 'ENZYMES', 'range_cat' => null, 'nv_min' => '0', 'nv_max' => '40', 'nv_uom' => 'U/L', 'sequence_id' => '7', 'field_active' => 1],

            ['lab_code' => 'BCHM', 'field_name' => 'albumin', 'field_desc' => 'Albumin', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => '3.5', 'nv_max' => '5.5', 'nv_uom' => 'g/dL', 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'total_bilirubin', 'field_desc' => 'Total Bilirubin', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => null, 'nv_max' => '1.0', 'nv_uom' => 'mg/dL', 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'direct_bilirubin', 'field_desc' => 'Direct Bilirubin', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => null, 'nv_max' => '0.4', 'nv_uom' => 'mg/dL', 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'cholesterol', 'field_desc' => 'Cholesterol', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => null, 'nv_max' => '5.2', 'nv_uom' => 'mmol/L', 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'creatinine', 'field_desc' => 'Creatinine', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => '1.0', 'nv_max' => '2.0', 'nv_uom' => 'mg/dL', 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'globulin', 'field_desc' => 'Globulin', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => '1.5', 'nv_max' => '3.5', 'nv_uom' => 'g/dL', 'sequence_id' => '6', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'glucose', 'field_desc' => 'Glucose', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => '80', 'nv_max' => '120', 'nv_uom' => 'mg/dL', 'sequence_id' => '7', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'protein', 'field_desc' => 'Protein (Total)', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => '6.3', 'nv_max' => '8.0', 'nv_uom' => 'g/dL', 'sequence_id' => '8', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'triglycerides', 'field_desc' => 'Triglycerides', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => '40', 'nv_max' => '200', 'nv_uom' => 'mg/dL', 'sequence_id' => '9', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'urea', 'field_desc' => 'Urea', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => '20', 'nv_max' => '40', 'nv_uom' => 'mg/dL', 'sequence_id' => '10', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'uric_acid', 'field_desc' => 'Uric Acid', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => '2.0', 'nv_max' => '4.0', 'nv_uom' => 'mg/dL', 'sequence_id' => '11', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'fbs', 'field_desc' => 'FBS', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => '>=126 mg/dl', 'sequence_id' => '12', 'field_active' => 1],
            ['lab_code' => 'BCHM', 'field_name' => 'rbs', 'field_desc' => 'RBS', 'group_cat' => 'OTHERS', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => '>= 200mg/dl', 'sequence_id' => '13', 'field_active' => 1],

            ['lab_code' => 'SPTM', 'field_name' => 'visual_appearance', 'field_desc' => 'Visual Appearance', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'SPTM', 'field_name' => 'reading', 'field_desc' => 'Reading/Number of Plusses(+)', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'SPTM', 'field_name' => 'data_collection_code', 'field_desc' => 'Sequence Number of Sputum', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'SPTM', 'field_name' => 'findings_code', 'field_desc' => 'Sputum Exam Result', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            //['lab_code' => 'SPTM', 'field_name' => 'period', 'field_desc' => 'Period of Sputum Exam', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            //['lab_code' => 'SPTM', 'field_name' => 'diagnosis', 'field_desc' => 'Final Lab Diagnosis', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],
            // ['lab_code' => 'SPTM', 'field_name' => 'collection_date1', 'field_desc' => 'Collection Date', 'group_cat' => 'SPECIMEN #1', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            // ['lab_code' => 'SPTM', 'field_name' => 'visual_appearance1', 'field_desc' => 'Visual Appearance', 'group_cat' => 'SPECIMEN #1', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            // ['lab_code' => 'SPTM', 'field_name' => 'reading1', 'field_desc' => 'Reading', 'group_cat' => 'SPECIMEN #1', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            // ['lab_code' => 'SPTM', 'field_name' => 'result1', 'field_desc' => 'Sputum Exam Result', 'group_cat' => 'SPECIMEN #1', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            // ['lab_code' => 'SPTM', 'field_name' => 'period', 'field_desc' => 'Period of Sputum Exam', 'group_cat' => 'SPECIMEN #1', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            // ['lab_code' => 'SPTM', 'field_name' => 'diagnosis', 'field_desc' => 'Final Lab Diagnosis', 'group_cat' => 'SPECIMEN #1', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],

            // ['lab_code' => 'SPTM', 'field_name' => 'collection_date2', 'field_desc' => 'Collection Date', 'group_cat' => 'SPECIMEN #2', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            // ['lab_code' => 'SPTM', 'field_name' => 'visual_appearance2', 'field_desc' => 'Visual Appearance', 'group_cat' => 'SPECIMEN #2', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            // ['lab_code' => 'SPTM', 'field_name' => 'reading2', 'field_desc' => 'Reading', 'group_cat' => 'SPECIMEN #2', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            // ['lab_code' => 'SPTM', 'field_name' => 'result2', 'field_desc' => 'Sputum Exam Result', 'group_cat' => 'SPECIMEN #2', 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],

            ['lab_code' => 'GRMS', 'field_name' => 'nugent_score', 'field_desc' => 'Nugent Score', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'GRMS', 'field_name' => 'fungal_elements', 'field_desc' => 'Fungal Elements', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'GRMS', 'field_name' => 'pus_cells', 'field_desc' => 'Pus Cells', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'GRMS', 'field_name' => 'gram_negative', 'field_desc' => 'Gram Negative Diplococci', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],

            ['lab_code' => 'SSMR', 'field_name' => 'site_slit1', 'field_desc' => '1', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'site_slit2', 'field_desc' => '2', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'site_slit3', 'field_desc' => '3', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'site_slit4', 'field_desc' => '4', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'site_slit5', 'field_desc' => '5', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'site_slit6', 'field_desc' => '6', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],

            ['lab_code' => 'SSMR', 'field_name' => 'bac_index1', 'field_desc' => '1', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'bac_index2', 'field_desc' => '2', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'bac_index3', 'field_desc' => '3', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'bac_index4', 'field_desc' => '4', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'bac_index5', 'field_desc' => '5', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'bac_index6', 'field_desc' => '6', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],

            ['lab_code' => 'SSMR', 'field_name' => 'morp_index1', 'field_desc' => '1', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'morp_index2', 'field_desc' => '2', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'morp_index3', 'field_desc' => '3', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'morp_index4', 'field_desc' => '4', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'morp_index5', 'field_desc' => '5', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'morp_index6', 'field_desc' => '6', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],

            ['lab_code' => 'SSMR', 'field_name' => 'comment1', 'field_desc' => '1', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'comment2', 'field_desc' => '2', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'comment3', 'field_desc' => '3', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'comment4', 'field_desc' => '4', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'comment5', 'field_desc' => '5', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'SSMR', 'field_name' => 'comment6', 'field_desc' => '6', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],

            ['lab_code' => 'SRLG', 'field_name' => 'hiv', 'field_desc' => 'HIV', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'SRLG', 'field_name' => 'hcv', 'field_desc' => 'HCV', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'SRLG', 'field_name' => 'anti_streaptolysin', 'field_desc' => 'Anti-Streptolysin - O', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'SRLG', 'field_name' => 'reactive_protein', 'field_desc' => 'C - Reactive Protein', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'SRLG', 'field_name' => 'rheumatoid_factor', 'field_desc' => 'Rheumatoid Factor', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'SRLG', 'field_name' => 'rapid_plasma', 'field_desc' => 'Rapid Plasma Reagin', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],

            ['lab_code' => 'MCRP', 'field_name' => 'parasite_type', 'field_desc' => 'Parasite Type', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'MCRP', 'field_name' => 'slide_number', 'field_desc' => 'Slide Number', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'MCRP', 'field_name' => 'parasite_count', 'field_desc' => 'Parasite Count', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],

            ['lab_code' => 'MRDT', 'field_name' => 'parasite_type', 'field_desc' => 'Parasite Type', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'MRDT', 'field_name' => 'rdt_number', 'field_desc' => 'RDT Number', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],

            ['lab_code' => 'GXPT', 'field_name' => 'collection_date', 'field_desc' => 'Collection Date', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'GXPT', 'field_name' => 'release_date', 'field_desc' => 'Release Date', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'GXPT', 'field_name' => 'mtb', 'field_desc' => 'MTB', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'GXPT', 'field_name' => 'rif', 'field_desc' => 'Rif', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'GXPT', 'field_name' => 'specimen_code', 'field_desc' => 'Specimen Code', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],

            ['lab_code' => 'XRAY', 'field_name' => 'type', 'field_desc' => 'Type', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'XRAY', 'field_name' => 'result', 'field_desc' => 'Result/Findings', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],

            ['lab_code' => 'USND', 'field_name' => 'type', 'field_desc' => 'Type', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'USND', 'field_name' => 'result', 'field_desc' => 'Result/Findings', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],

            ['lab_code' => 'BPSY', 'field_name' => 'type', 'field_desc' => 'Type', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'BPSY', 'field_name' => 'result', 'field_desc' => 'Result/Findings', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],

            ['lab_code' => 'CXRAY', 'field_name' => 'findings_code', 'field_desc' => 'Findings', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'CXRAY', 'field_name' => 'remarks_findings', 'field_desc' => 'Remarks Findings', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'CXRAY', 'field_name' => 'observation_code', 'field_desc' => 'Observation', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'CXRAY', 'field_name' => 'remarks_observation', 'field_desc' => 'Remarks Observation', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],

            ['lab_code' => 'LPFL', 'field_name' => 'ldl', 'field_desc' => 'LDL', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => 'mg/dl', 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'LPFL', 'field_name' => 'hdl', 'field_desc' => 'HDL', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => 'mg/dl', 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'LPFL', 'field_name' => 'cholesterol', 'field_desc' => 'Cholesterol', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => 'mg/dl', 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'LPFL', 'field_name' => 'triglycerides', 'field_desc' => 'Triglycerides', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => 'mg/dl', 'sequence_id' => '4', 'field_active' => 1],

            ['lab_code' => 'OGTT', 'field_name' => 'fasting_exam_mg', 'field_desc' => 'Gram Negative Diplococci', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'OGTT', 'field_name' => 'fasting_exam_mmol', 'field_desc' => 'Gram Negative Diplococci', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],
            ['lab_code' => 'OGTT', 'field_name' => 'ogtt_one_hour_mg', 'field_desc' => 'Gram Negative Diplococci', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '3', 'field_active' => 1],
            ['lab_code' => 'OGTT', 'field_name' => 'ogtt_one_hour_mmol', 'field_desc' => 'Gram Negative Diplococci', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '4', 'field_active' => 1],
            ['lab_code' => 'OGTT', 'field_name' => 'ogtt_two_hour_mg', 'field_desc' => 'Gram Negative Diplococci', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '5', 'field_active' => 1],
            ['lab_code' => 'OGTT', 'field_name' => 'ogtt_two_hour_mmol', 'field_desc' => 'Gram Negative Diplococci', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '6', 'field_active' => 1],

            ['lab_code' => 'FBS', 'field_name' => 'glucose', 'field_desc' => 'Glucose', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => 'mg/dl', 'sequence_id' => '1', 'field_active' => 1],

            ['lab_code' => 'RBS', 'field_name' => 'glucose', 'field_desc' => 'Glucose', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => 'mg/dl', 'sequence_id' => '1', 'field_active' => 1],

            ['lab_code' => 'ECG', 'field_name' => 'findings_code', 'field_desc' => 'Findings', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],

            ['lab_code' => 'PSMR', 'field_name' => 'findings', 'field_desc' => 'Findings', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],
            ['lab_code' => 'PSMR', 'field_name' => 'impression', 'field_desc' => 'Impression', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '2', 'field_active' => 1],

            ['lab_code' => 'CRTN', 'field_name' => 'findings', 'field_desc' => 'Findings', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => 'mg/dl', 'sequence_id' => '1', 'field_active' => 1],

            ['lab_code' => 'PPD', 'field_name' => 'findings_code', 'field_desc' => 'Findings', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],

            ['lab_code' => 'FOBT', 'field_name' => 'findings_code', 'field_desc' => 'Findings', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => null, 'sequence_id' => '1', 'field_active' => 1],

            ['lab_code' => 'HBA', 'field_name' => 'findings', 'field_desc' => 'Findings', 'group_cat' => null, 'range_cat' => null, 'nv_min' => null, 'nv_max' => null, 'nv_uom' => 'mmol/mol', 'sequence_id' => '1', 'field_active' => 1],

        ], ['lab_code', 'field_name']);
    }
}
