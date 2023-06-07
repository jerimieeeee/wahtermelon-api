<?php

namespace App\Http\Resources\API\V1\GenderBasedViolence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientGbvIntakeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->when(! $this->relationLoaded('patient'), $this->patient_id),
            'patient' => $this->whenLoaded('patient'),
            'user_id' => $this->when(! $this->relationLoaded('user'), $this->user_id),
            'user' => $this->whenLoaded('user'),
            'facility_code' => $this->when(! $this->relationLoaded('facility'), $this->facility_code),
            'facility' => $this->whenLoaded('facility'),
            'case_number' => $this->case_number,
            'case_date' => $this->case_date,
            'primary_complaint_id' => $this->when(! $this->relationLoaded('complaint'), $this->primary_complaint_id),
            'complaint' => $this->whenLoaded('complaint'),
            'service_id' => $this->when(! $this->relationLoaded('service'), $this->service_id),
            'service' => $this->whenLoaded('service'),
            'primary_complaint_remarks' => $this->primary_complaint_remarks,
            'physical_abuse_flag' => $this->physical_abuse_flag,
            'sexual_abuse_flag' => $this->sexual_abuse_flag,
            'neglect_abuse_flag' => $this->neglect_abuse_flag,
            'emotional_abuse_flag' => $this->emotional_abuse_flag,
            'economic_abuse_flag' => $this->economic_abuse_flag,
            'utv_abuse_flag' => $this->utv_abuse_flag,
            'others_abuse_flag' => $this->others_abuse_flag,
            'others_abuse_remarks' => $this->others_abuse_remarks,
            'service_remarks' => $this->service_remarks,
            'neglect_remarks' => $this->neglect_remarks,
            'behavioral_remarks' => $this->behavioral_remarks,
            'economic_status_id' => $this->when(! $this->relationLoaded('economic'), $this->economic_status_id),
            'number_of_children' => $this->number_of_children,
            'number_of_individual_members' => $this->number_of_individual_members,
            'number_of_family' => $this->number_of_family,
            'economic' => $this->whenLoaded('economic'),
            'same_address_flag' => $this->same_address_flag,
            'barangay_code' => $this->when(! $this->relationLoaded('barangay'), $this->barangay_code),
            'barangay' => $this->whenLoaded('barangay'),
            'address' => $this->address,
            'direction_to_address' => $this->direction_to_address,
            'guardian_name' => $this->guardian_name,
            'guardian_address' => $this->guardian_address,
            'relation_to_child_id' => $this->when(! $this->relationLoaded('relation'), $this->relation_to_child_id),
            'relation' => $this->whenLoaded('relation'),
            'guardian_contact_info' => $this->guardian_contact_info,
            'incest_case_flag' => $this->incest_case_flag,
            'same_bed_adult_male_flag' => $this->same_bed_adult_male_flag,
            'same_bed_adult_female_flag' => $this->same_bed_adult_female_flag,
            'same_bed_child_male_flag' => $this->same_bed_child_male_flag,
            'same_bed_child_female_flag' => $this->same_bed_child_female_flag,
            'same_room_adult_female_flag' => $this->same_room_adult_female_flag,
            'same_room_child_male_flag' => $this->same_room_child_male_flag,
            'sleeping_arrangement_id' => $this->when(! $this->relationLoaded('sleepingArrangement'), $this->sleeping_arrangement_id),
            'sleepingArrangement' => $this->whenLoaded('sleepingArrangement'),
            'abuse_living_arrangement_id' => $this->when(! $this->relationLoaded('livingArrangement'), $this->abuse_living_arrangement_id),
            'livingArrangement' => $this->whenLoaded('livingArrangement'),
            'abuse_living_arrangement_remarks' => $this->abuse_living_arrangement_remarks,
            'present_living_arrangement_id' => $this->when(! $this->relationLoaded('presentArrangement'), $this->present_living_arrangement_id),
            'presentArrangement' => $this->whenLoaded('presentArrangement'),
            'present_living_arrangement_remarks' => $this->present_living_arrangement_remarks,
            'neglect' => $this->whenLoaded('neglect'),
            'complaints' => $this->whenLoaded('complaints'),
            'behavior' => $this->whenLoaded('behavior'),
            'referral' => $this->whenLoaded('referral'),
            'interview' => $this->whenLoaded('interview'),
            'interviewPerpetrator' => $this->whenLoaded('interviewPerpetrator'),
            'interviewSexualAbuses' => $this->whenLoaded('interviewSexualAbuses'),
            'interviewPhysicalAbuses' => $this->whenLoaded('interviewPhysicalAbuses'),
            'interviewNeglectAbuses' => $this->whenLoaded('interviewNeglectAbuses'),
            'interviewEmotionalAbuses' => $this->whenLoaded('interviewEmotionalAbuses'),
            'interviewSummaries' => $this->whenLoaded('interviewSummaries'),
            'interviewDevScreening' => $this->whenLoaded('interviewDevScreening'),

            'vaw_physical_flag' => $this->vaw_physical_flag,
            'vaw_sexual_flag' => $this->vaw_sexual_flag,
            'vaw_psychological_flag' => $this->vaw_psychological_flag,
            'vaw_economic_flag' => $this->vaw_economic_flag,
            'rape_sex_intercourse_flag' => $this->rape_sex_intercourse_flag,
            'rape_sex_assault_flag' => $this->rape_sex_assault_flag,
            'rape_incest_flag' => $this->rape_incest_flag,
            'rape_statutory_flag' => $this->rape_statutory_flag,
            'rape_marital_flag' => $this->rape_marital_flag,
            'harassment_verbal_flag' => $this->harassment_verbal_flag,
            'harassment_physical_flag' => $this->harassment_physical_flag,
            'harassment_object_flag' => $this->harassment_object_flag,
            'child_abuse_engaged_flag' => $this->child_abuse_engaged_flag,
            'child_abuse_sexual_flag' => $this->child_abuse_sexual_flag,
            'child_abuse_physical_flag' => $this->child_abuse_physical_flag,
            'child_abuse_emotional_flag' => $this->child_abuse_emotional_flag,
            'child_abuse_economic_flag' => $this->child_abuse_economic_flag,
            'wcpd_others' => $this->wcpd_others,

            'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
