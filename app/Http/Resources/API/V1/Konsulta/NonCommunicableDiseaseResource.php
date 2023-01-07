<?php

namespace App\Http\Resources\API\V1\Konsulta;

use Illuminate\Http\Resources\Json\JsonResource;

class NonCommunicableDiseaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            '_attributes' => [
                'pQid1_Yn' => "",
                'pQid2_Yn' => "",
                'pQid3_Yn' => "",
                'pQid4_Yn' => "",
                'pQid5_Ynx' => "",
                'pQid6_Yn' => "",
                'pQid7_Yn' => "",
                'pQid8_Yn' => "",
                'pQid9_Yn' => "",
                'pQid10_Yn' => "",
                'pQid11_Yn' => "",
                'pQid12_Yn' => "",
                'pQid13_Yn' => "",
                'pQid14_Yn' => "",
                'pQid15_Yn' => "",
                'pQid16_Yn' => "",
                'pQid17_Abcde' => "",
                'pQid18_Yn' => "",
                'pQid19_Yn' => "",
                'pQid19_Fbsmg' => "",
                'pQid19_Fbsmmol' => "",
                'pQid19_Fbsdate' => "",
                'pQid20_Yn' => "",
                'pQid20_Choleval' => "",
                'pQid20_Choledate' => "",
                'pQid21_Yn' => "",
                'pQid21_Ketonval' => "",
                'pQid21_Ketondate' => "",
                'pQid22_Yn' => "",
                'pQid22_Proteinval' => "",
                'pQid22_Proteindate' => "",
                'pQid23_Yn' => "",
                'pQid24_Yn' => "",
                'pReportStatus' => "U",
                'pDeficiencyRemarks' => ""
            ]
        ];
    }
}
