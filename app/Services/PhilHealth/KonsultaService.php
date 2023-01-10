<?php

namespace App\Services\PhilHealth;

use App\Http\Resources\API\V1\Konsulta\ConsultationResource;
use App\Http\Resources\API\V1\Konsulta\EnlistmentResource;
use App\Http\Resources\API\V1\Konsulta\MedicineResource;
use App\Http\Resources\API\V1\Konsulta\ProfileResource;
use App\Models\User;
use App\Models\V1\Consultation\Consult;
use App\Models\V1\Konsulta\KonsultaTransmittal;
use App\Models\V1\Medicine\MedicinePrescription;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientHistory;
use App\Models\V1\Patient\PatientMenstrualHistory;
use App\Models\V1\Patient\PatientPhilhealth;
use App\Models\V1\Patient\PatientSocialHistory;
use App\Models\V1\Patient\PatientSurgicalHistory;
use App\Models\V1\Patient\PatientVitals;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\ArrayToXml\ArrayToXml;

class KonsultaService
{
    public function generateXml()
    {
        $root = [
            'rootElementName' => 'PCB',
            '_attributes' => [
                'pUsername'=>"",
                'pPassword'=>"",
                'pHciAccreNo'=>"P91034068",
                'pPMCCNo'=>"Z10681",
                'pEnlistTotalCnt'=>"1",
                'pProfileTotalCnt'=>"1",
                'pSoapTotalCnt'=>"1",
                'pCertificationId'=>"KON-DUMMYSCERTZ10681",
                'pHciTransmittalNumber'=>"RP9103406820230100001"
            ]
        ];
        $firstTrancheArray = [
            'ENLISTMENTS' => [
                'ENLISTMENT' => [
                    '_attributes' => [
                        'pHciCaseNo'=>"TP9103406820230100001",
                        'pHciTransNo'=>"PP9103406820230100001",
                        'pEffYear'=>"2023",
                        'pEnlistStat'=>"1",
                        'pEnlistDate'=>"2023-01-06",
                        'pPackageType'=>"K",
                        'pMemPin'=>"030263078345",
                        'pMemFname'=>"AOMIDDLENAME",
                        'pMemMname'=>"AOFIRSTNAME",
                        'pMemLname'=>"AOLASTNAME",
                        'pMemExtname'=>"",
                        'pMemDob'=>"1995-02-14",
                        'pPatientPin'=>"242500004472",
                        'pPatientFname'=>"DEP2AOFIRSTNAME",
                        'pPatientMname'=>"AOMIDDLENAME",
                        'pPatientLname'=>"AOLASTNAME",
                        'pPatientExtname'=>"",
                        'pPatientSex'=>"F",
                        'pPatientDob'=>"2020-08-01",
                        'pPatientType'=>"DD",
                        'pPatientMobileNo'=>"09090000000",
                        'pPatientLandlineNo'=>"",
                        'pWithConsent'=>"Y",
                        'pTransDate'=>"2023-01-10",
                        'pCreatedBy'=>"TEST01",
                        'pReportStatus'=>"U",
                        'pDeficiencyRemarks'=>""
                    ]
                ],
                //$this->enlistments(),
            ],
            'PROFILING' => [
                //$this->profiling(),
                'PROFILE' => [
                    '_attributes' => [
                        'pHciTransNo'=>"PP9103406820230100001",
                        'pHciCaseNo'=>"TP9103406820230100001",
                        'pProfDate'=>"2022-08-26",
                        'pPatientPin'=>"242500004774",
                        'pPatientType'=>"DD",
                        'pPatientAge'=>"1 YR(S), 0 MO(S), 25 DAY(S)",
                        'pMemPin'=>"030263078507",
                        'pEffYear'=>"2022",
                        'pATC'=>"JruBaQ2Y",
                        'pIsWalkedIn'=>"N",
                        'pTransDate'=>"2022-08-27",
                        'pReportStatus'=>"U",
                        'pDeficiencyRemarks'=>""
                    ],
                    'MEDHISTS' => [
                        'MEDHIST' => [
                            [
                                '_attributes' => [
                                    'pMdiseaseCode'=>"001", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                                ]
                            ],
                            /*[
                                '_attributes' => [
                                    'pMdiseaseCode'=>"002", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                                ],
                            ]*/
                        ],
                    ],
                    'MHSPECIFICS' => [
                        'MHSPECIFIC' => [
                            '_attributes' => [
                                'pMdiseaseCode'=>"001", 'pSpecificDesc'=>"SAMPLE ALLERGY", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                            ]
                        ]
                    ],
                    'SURGHISTS' => [
                        'SURGHIST' => [
                            '_attributes' => [
                                'pSurgDesc'=>"SAMPLE OPERATION", 'pSurgDate'=>"2022-06-01", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                            ]
                        ]
                    ],
                    'FAMHISTS' => [
                        'FAMHIST' => [
                            '_attributes' => [
                                'pMdiseaseCode'=>"002", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                            ]
                        ]
                    ],
                    'FHSPECIFICS' => [
                        'FHSPECIFIC' => [
                            '_attributes' => [
                                'pMdiseaseCode'=>"", 'pSpecificDesc'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                            ]
                        ]
                    ],
                    'SOCHIST' => [
                        '_attributes' => [
                            'pIsSmoker'=>"N",
                            'pNoCigpk'=>"",
                            'pIsAdrinker'=>"N",
                            'pNoBottles'=>"",
                            'pIllDrugUser'=>"N",
                            'pIsSexuallyActive'=>"N",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'IMMUNIZATIONS' => [
                        'IMMUNIZATION' => [
                            '_attributes' => [
                                'pChildImmcode'=>"C01",
                                'pYoungwImmcode'=>"",
                                'pPregwImmcode'=>"",
                                'pElderlyImmcode'=>"",
                                'pOtherImm'=>"",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ]
                    ],
                    'MENSHIST' => [
                        '_attributes' => [
                            'pMenarchePeriod'=>"",
                            'pLastMensPeriod'=>"",
                            'pPeriodDuration'=>"",
                            'pMensInterval'=>"",
                            'pPadsPerDay'=>"",
                            'pOnsetSexIc'=>"",
                            'pBirthCtrlMethod'=>"",
                            'pIsMenopause'=>"",
                            'pMenopauseAge'=>"",
                            'pIsApplicable'=>"N",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'PREGHIST' => [
                        '_attributes' => [
                            'pPregCnt'=>"",
                            'pDeliveryCnt'=>"",
                            'pDeliveryTyp'=>"",
                            'pFullTermCnt'=>"",
                            'pPrematureCnt'=>"",
                            'pAbortionCnt'=>"",
                            'pLivChildrenCnt'=>"",
                            'pWPregIndhyp'=>"",
                            'pWFamPlan'=>"N",
                            'pIsApplicable'=>"N",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'PEPERT' => [
                        '_attributes' => [
                            'pSystolic'=>"95",
                            'pDiastolic'=>"58",
                            'pHr'=>"110",
                            'pRr'=>"30",
                            'pTemp'=>"36.10",
                            'pHeight'=>"0",
                            'pWeight'=>"8.9",
                            'pBMI'=>"0",
                            'pZScore'=>"",
                            'pLeftVision'=>"20",
                            'pRightVision'=>"20",
                            'pLength'=>"63",
                            'pHeadCirc'=>"46",
                            'pSkinfoldThickness'=>"46",
                            'pWaist'=>"48",
                            'pHip'=>"50",
                            'pLimbs'=>"40",
                            'pMidUpperArmCirc'=>"12.5",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'BLOODTYPE' => [
                        '_attributes' => [
                            'pBloodType'=>"B+",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'PEGENSURVEY' => [
                        '_attributes' => [
                            'pGenSurveyId'=>"1",
                            'pGenSurveyRem'=>"",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'PEMISCS' => [
                        'PEMISC' => [
                            '_attributes' => [
                                'pSkinId'=>"",
                                'pHeentId'=>"",
                                'pChestId'=>"",
                                'pHeartId'=>"",
                                'pAbdomenId'=>"",
                                'pNeuroId'=>"",
                                'pRectalId'=>"",
                                'pGuId'=>"",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ],
                        ],
                    ],
                    'PESPECIFIC' => [
                        '_attributes' => [
                            'pSkinRem'=>"",
                            'pHeentRem'=>"",
                            'pChestRem'=>"",
                            'pHeartRem'=>"",
                            'pAbdomenRem'=>"",
                            'pNeuroRem'=>"",
                            'pRectalRem'=>"",
                            'pGuRem'=>"SAMPLE REMARKS",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'NCDQANS' => [
                        '_attributes' => [
                            'pQid1_Yn'=>"",
                            'pQid2_Yn'=>"",
                            'pQid3_Yn'=>"",
                            'pQid4_Yn'=>"",
                            'pQid5_Ynx'=>"",
                            'pQid6_Yn'=>"",
                            'pQid7_Yn'=>"",
                            'pQid8_Yn'=>"",
                            'pQid9_Yn'=>"",
                            'pQid10_Yn'=>"",
                            'pQid11_Yn'=>"",
                            'pQid12_Yn'=>"",
                            'pQid13_Yn'=>"",
                            'pQid14_Yn'=>"",
                            'pQid15_Yn'=>"",
                            'pQid16_Yn'=>"",
                            'pQid17_Abcde'=>"",
                            'pQid18_Yn'=>"",
                            'pQid19_Yn'=>"",
                            'pQid19_Fbsmg'=>"",
                            'pQid19_Fbsmmol'=>"",
                            'pQid19_Fbsdate'=>"",
                            'pQid20_Yn'=>"",
                            'pQid20_Choleval'=>"",
                            'pQid20_Choledate'=>"",
                            'pQid21_Yn'=>"",
                            'pQid21_Ketonval'=>"",
                            'pQid21_Ketondate'=>"",
                            'pQid22_Yn'=>"",
                            'pQid22_Proteinval'=>"",
                            'pQid22_Proteindate'=>"",
                            'pQid23_Yn'=>"",
                            'pQid24_Yn'=>"",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ],
                ],
            ],
            'SOAPS' => [
                'SOAP' => [
                    '_attributes' => [
                        'pHciCaseNo'=>"",
                        'pHciTransNo'=>"",
                        'pSoapDate'=>"",
                        'pPatientPin'=>"",
                        'pPatientType'=>"",
                        'pMemPin'=>"",
                        'pEffYear'=>"",
                        'pATC'=>"",
                        'pIsWalkedIn'=>"",
                        'pCoPay'=>"",
                        'pTransDate'=>"",
                        'pReportStatus'=>"U",
                        'pDeficiencyRemarks'=>""
                    ],
                    'SUBJECTIVE' => [
                        '_attributes' => [
                            'pIllnessHistory'=>"",
                            'pSignsSymptoms'=>"",
                            'pOtherComplaint'=>"",
                            'pPainSite'=>"",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'PEPERT' => [
                        '_attributes' => [
                            'pSystolic'=>"",
                            'pDiastolic'=>"",
                            'pHr'=>"", 'pRr'=>"",
                            'pTemp'=>"",
                            'pHeight'=>"",
                            'pWeight'=>"",
                            'pBMI'=>"",
                            'pZScore'=>"",
                            'pLeftVision'=>"",
                            'pRightVision'=>"",
                            'pLength'=>"",
                            'pHeadCirc'=>"",
                            'pSkinfoldThickness'=>"",
                            'pWaist'=>"",
                            'pHip'=>"",
                            'pLimbs'=>"",
                            'pMidUpperArmCirc'=>"",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'PEMISCS' => [
                        'PEMISC' => [
                            '_attributes' => [
                                'pSkinId'=>"",
                                'pHeentId'=>"",
                                'pChestId'=>"",
                                'pHeartId'=>"",
                                'pAbdomenId'=>"",
                                'pNeuroId'=>"",
                                'pGuId'=>"",
                                'pRectalId'=>"",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ],
                    ],
                    'PESPECIFIC' => [
                        '_attributes' => [
                            'pSkinRem'=>"",
                            'pHeentRem'=>"",
                            'pChestRem'=>"",
                            'pHeartRem'=>"",
                            'pAbdomenRem'=>"",
                            'pNeuroRem'=>"",
                            'pRectalRem'=>"",
                            'pGuRem'=>"",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'ICDS' => [
                        'ICD' => [
                            '_attributes' => [
                                'pIcdCode'=>"",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ],
                    ],
                    'DIAGNOSTICS' => [
                        'DIAGNOSTIC' => [
                            '_attributes' => [
                                'pDiagnosticId'=>"",
                                'pOthRemarks'=>"",
                                'pIsPhysicianRecommendation'=>"",
                                'pPatientRemarks'=>"",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ],
                    ],
                    'MANAGEMENTS' => [
                        'MANAGEMENT' => [
                            '_attributes' => [
                                'pManagementId'=>"",
                                'pOthRemarks'=>"",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ],
                    ],
                    'ADVICE' => [
                        '_attributes' => [
                            'pRemarks'=>"",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ],
                ],
            ],
            'DIAGNOSTICEXAMRESULTS' => [
                'DIAGNOSTICEXAMRESULT' => [

                        '_attributes' => [
                            'pHciCaseNo'=>"TP9103406820230100001",
                            'pHciTransNo'=>"PP9103406820230100001",
                            'pPatientPin'=>"242500004774",
                            'pPatientType'=>"DD",
                            'pMemPin'=>"030263078507",
                            'pEffYear'=>"2022"
                        ],
                        'FBSS' => [
                            'FBS' => [
                                '_attributes' => [
                                    'pReferralFacility'=>"SAMPLE REFERRAL FACILITY",
                                    'pLabDate'=>"2022-08-26",
                                    'pGlucoseMg'=>"45",
                                    'pGlucoseMmol'=>"7.8",
                                    'pDateAdded'=>"2022-08-27",
                                    'pStatus'=>"D",
                                    'pDiagnosticLabFee'=>"0.00",
                                    'pReportStatus'=>"U",
                                    'pDeficiencyRemarks'=>""
                                ]
                            ],
                        ],
                        'RBSS' => [
                            'RBS' => [
                                '_attributes' => [
                                    'pReferralFacility'=>"",
                                    'pLabDate'=>"2022-08-26",
                                    'pGlucoseMg'=>"45",
                                    'pGlucoseMmol'=>"7.8",
                                    'pDateAdded'=>"2022-08-27",
                                    'pStatus'=>"D",
                                    'pDiagnosticLabFee'=>"0.00",
                                    'pReportStatus'=>"U",
                                    'pDeficiencyRemarks'=>""
                                ]
                            ],
                        ],
                        /*'CBCS' => [
                            'CBC' => [
                                '_attributes' => [
                                    'pReferralFacility'=>"", 'pLabDate'=>"2022-08-27", 'pHematocrit'=>"35", 'pHemoglobinG'=>"11.9", 'pHemoglobinMmol'=>"-", 'pMhcPg'=>"32.5", 'pMhcFmol'=>"-", 'pMchcGhb'=>"32.5", 'pMchcMmol'=>"-", 'pMcvUm'=>"82.5", 'pMcvFl'=>"-", 'pWbc1000'=>"3.9", 'pWbc10'=>"-", 'pMyelocyte'=>"0", 'pNeutrophilsBnd'=>"0-5", 'pNeutrophilsSeg'=>"40-60", 'pLymphocytes'=>"20-40", 'pMonocytes'=>"4-8", 'pEosinophils'=>"1-3", 'pBasophils'=>"0-1", 'pPlatelet'=>"200,000-500,000", 'pDateAdded'=>"2022-08-31", 'pStatus'=>"D", 'pDiagnosticLabFee'=>"120.00", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                                ]
                            ],
                        ],*/
                    /*],
                    [
                        '_attributes' => [
                            'pHciCaseNo'=>"TH9000000120220800001",
                            'pHciTransNo'=>"PH9000000120220800001",
                            'pPatientPin'=>"242500004774",
                            'pPatientType'=>"DD",
                            'pMemPin'=>"030263078507",
                            'pEffYear'=>"2022"
                        ],
                        'CBCS' => [
                            'CBC' => [
                                '_attributes' => [
                                    'pReferralFacility'=>"", 'pLabDate'=>"2022-08-27", 'pHematocrit'=>"35", 'pHemoglobinG'=>"11.9", 'pHemoglobinMmol'=>"-", 'pMhcPg'=>"32.5", 'pMhcFmol'=>"-", 'pMchcGhb'=>"32.5", 'pMchcMmol'=>"-", 'pMcvUm'=>"82.5", 'pMcvFl'=>"-", 'pWbc1000'=>"3.9", 'pWbc10'=>"-", 'pMyelocyte'=>"0", 'pNeutrophilsBnd'=>"0-5", 'pNeutrophilsSeg'=>"40-60", 'pLymphocytes'=>"20-40", 'pMonocytes'=>"4-8", 'pEosinophils'=>"1-3", 'pBasophils'=>"0-1", 'pPlatelet'=>"200,000-500,000", 'pDateAdded'=>"2022-08-31", 'pStatus'=>"D", 'pDiagnosticLabFee'=>"120.00", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                                ]
                            ],
                        ],
                        'RBSS' => [
                            'RBS' => [
                                '_attributes' => [
                                    'pReferralFacility'=>"", 'pLabDate'=>"2022-08-26", 'pGlucoseMg'=>"45", 'pGlucoseMmol'=>"7.8", 'pDateAdded'=>"2022-08-27", 'pStatus'=>"D", 'pDiagnosticLabFee'=>"0.00", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                                ]
                            ],
                        ],
                    ],*/
                ],

            ],
            'MEDICINES' => [
                'MEDICINE' => [
                    '_attributes' => [
                        'pHciCaseNo'=>"",
                        'pHciTransNo'=>"",
                        'pCategory'=>"",
                        'pDrugCode'=>"",
                        'pGenericCode'=>"",
                        'pSaltCode'=>"",
                        'pStrengthCode'=>"",
                        'pFormCode'=>"",
                        'pUnitCode'=>"",
                        'pPackageCode'=>"",
                        'pOtherMedicine'=>"",
                        'pRoute'=>"",
                        'pQuantity'=>"",
                        'pActualUnitPrice'=>"",
                        'pTotalAmtPrice'=>"",
                        'pInstructionQuantity'=>"",
                        'pInstructionStrength'=>"",
                        'pInstructionFrequency'=>"",
                        'pPrescribingPhysician'=>"",
                        'pIsDispensed'=>"",
                        'pDateDispensed'=>"",
                        'pDispensingPersonnel'=>"",
                        'pIsApplicable'=>"",
                        'pDateAdded'=>"",
                        'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                    ]
                ],
            ],
        ];
        $result = new ArrayToXml($firstTrancheArray, $root);
        return $result->dropXmlDeclaration()->toXml();
    }

    public function createXml($transmittalNumber = '', $patientId = [], $tranche = 1, $revalidate = false)
    {
        if(empty($transmittalNumber)) {
            $prefix = 'R' . auth()->user()->konsultaCredential->accreditation_number . date('Ym');
            $transmittalNumber = IdGenerator::generate(['table' => 'konsulta_transmittals', 'field' => 'transmittal_number', 'length' => 21, 'prefix' => $prefix, 'reset_on_prefix_change' => true]);
        }

        $enlistments = $this->enlistments($transmittalNumber, $patientId, $revalidate);
        $profiling = $this->profilings($transmittalNumber, $patientId, $revalidate);
        $soaps = $this->soaps($transmittalNumber, $patientId, $tranche, $revalidate);
        $enlistmentCount = count($enlistments['ENLISTMENT'][0]);
        $profileCount = count($profiling['PROFILE'][0]);
        $soapCount = count($soaps[0]['SOAP'][0]);

        $root = [
            'rootElementName' => 'PCB',
            '_attributes' => [
                'pUsername' => "",
                'pPassword' => "",
                'pHciAccreNo' => auth()->user()->konsultaCredential->accreditation_number?? "",
                'pPMCCNo' => auth()->user()->konsultaCredential->pmcc_number?? "",
                'pEnlistTotalCnt' => $enlistmentCount,
                'pProfileTotalCnt' => $profileCount,
                'pSoapTotalCnt' => $soapCount,
                'pCertificationId' => auth()->user()->konsultaCredential->software_certification_id?? "",
                'pHciTransmittalNumber' => $transmittalNumber
            ]
        ];
        $sample = [[

            '_attributes' => [
                'pHciCaseNo'=>"TH9000000120220800001",
                'pHciTransNo'=>"PH9000000120220800001",
                'pPatientPin'=>"242500004774",
                'pPatientType'=>"DD",
                'pMemPin'=>"030263078507",
                'pEffYear'=>"2022"
            ],
            'FBSS' => [
                'FBS' => [
                    '_attributes' => [
                        'pReferralFacility'=>"SAMPLE REFERRAL FACILITY",
                        'pLabDate'=>"2022-08-26",
                        'pGlucoseMg'=>"45",
                        'pGlucoseMmol'=>"7.8",
                        'pDateAdded'=>"2022-08-27",
                        'pStatus'=>"D",
                        'pDiagnosticLabFee'=>"0.00",
                        'pReportStatus'=>"U",
                        'pDeficiencyRemarks'=>""
                    ]
                ],
            ],
            'RBSS' => [
                'RBS' => [
                    '_attributes' => [
                        'pReferralFacility'=>"",
                        'pLabDate'=>"2022-08-26",
                        'pGlucoseMg'=>"45",
                        'pGlucoseMmol'=>"7.8",
                        'pDateAdded'=>"2022-08-27",
                        'pStatus'=>"D",
                        'pDiagnosticLabFee'=>"0.00",
                        'pReportStatus'=>"U",
                        'pDeficiencyRemarks'=>""
                    ]
                ],
            ],
        ],];

        $array = [
            'ENLISTMENTS' => [$enlistments],
            'PROFILING' => [$profiling],
            'SOAPS' => [$soaps[0]],
            'DIAGNOSTICEXAMRESULTS' => [
                'DIAGNOSTICEXAMRESULT' => [array_merge($sample,[])]
            ],
            'MEDICINES' => [$soaps[1]
                /*'MEDICINE' => [
                    '_attributes' => [
                        'pHciCaseNo'=>"",
                        'pHciTransNo'=>"",
                        'pCategory'=>"",
                        'pDrugCode'=>"",
                        'pGenericCode'=>"",
                        'pSaltCode'=>"",
                        'pStrengthCode'=>"",
                        'pFormCode'=>"",
                        'pUnitCode'=>"",
                        'pPackageCode'=>"",
                        'pOtherMedicine'=>"",
                        'pRoute'=>"",
                        'pQuantity'=>"",
                        'pActualUnitPrice'=>"",
                        'pTotalAmtPrice'=>"",
                        'pInstructionQuantity'=>"",
                        'pInstructionStrength'=>"",
                        'pInstructionFrequency'=>"",
                        'pPrescribingPhysician'=>"",
                        'pIsDispensed'=>"",
                        'pDateDispensed'=>"",
                        'pDispensingPersonnel'=>"",
                        'pIsApplicable'=>"",
                        'pDateAdded'=>"",
                        'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                    ]
                ],*/
            ],
        ];
        $result = new ArrayToXml($array, $root);
        $xml = $result->dropXmlDeclaration()->toXml();
        return $this->storeXml($transmittalNumber, $xml, $tranche, $enlistmentCount, $profileCount, $soapCount);
        return $xml;
    }

    public function saveTransmittal($transmittalNumber, $tranche, $enlistmentCount, $profileCount, $soapCount, $xmlUrl, $report, $status)
    {
        KonsultaTransmittal::updateOrCreate(
            ['transmittal_number' => $transmittalNumber],
            ['total_enlistment' => $enlistmentCount, 'tranche' => $tranche, 'total_profile' => $profileCount, 'total_soap' => $soapCount, 'xml_url' => $xmlUrl, 'xml_status' => $status, 'xml_errors' => $report]
        );
    }

    public function storeXml($transmittalNumber = '', $xml, $tranche, $enlistmentCount, $profileCount, $soapCount)
    {
        $service = new SoapService();
        $fileName = "";
        $fileName = 'Konsulta/'.auth()->user()->facility_code.'/'.$tranche.auth()->user()->konsultaCredential->accreditation_number.'_'.date('Ymd').'_'.$transmittalNumber.'.xml.enc';
        Storage::disk('spaces')->put($fileName, $service->encryptData($xml));
        $xmlEnc = Storage::disk('spaces')->get($fileName);

        $report = $service->soapMethod('validateReport', ['pReport' => $xmlEnc, 'pReportTagging' => $tranche]);

        $this->saveTransmittal($transmittalNumber, $tranche, $enlistmentCount, $profileCount, $soapCount, $fileName, $report, !empty($report->success) ? 'V' : 'F');
        return $report;

    }

    public function enlistments($transmittalNumber = '', $patientId = [], $revalidate = false)
    {
        $enlistments = [];
        $patient = Patient::selectRaw('id AS patientID, case_number, first_name, middle_name, last_name, suffix_name, gender, birthdate, mobile_number, consent_flag');
        $user = User::selectRaw('id AS userID, CONCAT(first_name, " ", last_name) AS created_by');
        $data = PatientPhilhealth::query()
            ->joinSub($patient, 'patients', function($join){
                $join->on('patient_philhealth.patient_id', '=', 'patients.patientID');
            })
            ->joinSub($user, 'users', function($join){
                $join->on('patient_philhealth.user_id', '=', 'users.userID');
            })
            ->whereIn('membership_type_id', ['MM', 'DD'])
            ->when(!empty($patientId), fn($query) => $query->whereIn('patient_id', $patientId))
            ->when($revalidate, fn($query) => $query->where('transmittal_number', $transmittalNumber))
            //->wherePatientId('97a9157e-2705-4a10-b68d-211052b0c6ac')
            ->get();
        $data->map(fn($data, $key) => $data->update(['transmittal_number' => $transmittalNumber]));
        $enlistments['ENLISTMENT'] = [EnlistmentResource::collection($data->whenEmpty(fn() => [[]]))->resolve()];
        return $enlistments;
    }

    public function profiling()
    {
        $profile = ['PROFILE' => []];
        $patient = Patient::selectRaw('id, case_number, birthdate');
        $data = PatientPhilhealth::query()
                ->joinSub($patient, 'patients', function($join){
                    $join->on('patient_philhealth.patient_id', '=', 'patients.id');
                })
                ->get()
                ->map(function($data, $key){
                    $age = Carbon::parse($data->birthdate)->diff($data->enlistment_date);
                    $medhistory = PatientHistory::wherePatientId($data->patient_id)->whereCategory(1)->get()
                        ->map(function($data, $key){
                            return [
                                '_attributes' => [
                                    'pMdiseaseCode'=>$data->medical_history_id,
                                    'pReportStatus'=>"U",
                                    'pDeficiencyRemarks'=>""
                                ]
                            ];
                        });
                    $medhistorySpecific = PatientHistory::wherePatientId($data->patient_id)->whereCategory(1)->whereNotNull('remarks')->get()
                        ->map(function($data, $key){
                            return [
                                '_attributes' => [
                                    'pMdiseaseCode'=>$data->medical_history_id,
                                    'pSpecificDesc'=>$data->remarks,
                                    'pReportStatus'=>"U",
                                    'pDeficiencyRemarks'=>""
                                ]
                            ];
                        });
                    $medhistoryDefault = [
                        '_attributes' => [
                            'pMdiseaseCode'=>"",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ];
                    $medhistorySpecificDefault = [
                        '_attributes' => [
                            'pMdiseaseCode'=>"",
                            'pSpecificDesc'=>"",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ];

                    $familyHistory = PatientHistory::wherePatientId($data->patient_id)->whereCategory(2)->get()
                        ->map(function($data, $key){
                            return [
                                '_attributes' => [
                                    'pMdiseaseCode'=>$data->medical_history_id,
                                    'pReportStatus'=>"U",
                                    'pDeficiencyRemarks'=>""
                                ]
                            ];
                        });
                    $familyHistorySpecific = PatientHistory::wherePatientId($data->patient_id)->whereCategory(2)->whereNotNull('remarks')->get()
                        ->map(function($data, $key){
                            return [
                                '_attributes' => [
                                    'pMdiseaseCode'=>$data->medical_history_id,
                                    'pSpecificDesc'=>$data->remarks,
                                    'pReportStatus'=>"U",
                                    'pDeficiencyRemarks'=>""
                                ]
                            ];
                        });
                    $familyHistoryDefault = [
                        '_attributes' => [
                            'pMdiseaseCode'=>"",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ];
                    $familyHistorySpecificDefault = [
                        '_attributes' => [
                            'pMdiseaseCode'=>"",
                            'pSpecificDesc'=>"",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ];

                    $surgical = PatientSurgicalHistory::wherePatientId($data->patient_id)->get()
                        ->map(function($data, $key){
                            return [
                                '_attributes' => [
                                    'pSurgDesc'=>$data->operation,
                                    'pSurgDate'=>$data->operation_date,
                                    'pReportStatus'=>"U",
                                    'pDeficiencyRemarks'=>""
                                ]
                            ];
                        });
                    $surgicalDefault = [
                        '_attributes' => [
                            'pSurgDesc'=>"",
                            'pSurgDate'=>"",
                            'pReportStatus'=>"U",
                            'pDeficiencyRemarks'=>""
                        ]
                    ];

                    $socialHistory = PatientSocialHistory::wherePatientId($data->patient_id)->first();

                    $menstrualHistory = PatientMenstrualHistory::wherePatientId($data->patient_id)->first();

                    $patient = Patient::whereId($data->patient_id)->first();

                    $vitals = PatientVitals::wherePatientId($data->patient_id)->whereRaw("DATE_FORMAT(vitals_date, '%Y-%m-%d') = ?", $data->enlistment_date)->first();

                    return [
                        '_attributes' => [
                            'pHciTransNo' => 'P'.$data->transaction_number?? "",
                            'pHciCaseNo' => $data->case_number?? "",
                            'pProfDate' => $data->enlistment_date?? "",
                            'pPatientPin' => $data->philhealth_id?? "",
                            'pPatientType' => $data->membership_type_id?? "",
                            'pPatientAge' => "$age->y YR(S), $age->m MO(S), $age->d DAY(S)",
                            'pMemPin' => $data->member_pin?? "",
                            'pEffYear' => $data->effectivity_year?? "",
                            'pATC' => "JruBaQ2Y",
                            'pIsWalkedIn' => "N",
                            'pTransDate' => isset($data->created_at) ? $data->created_at->format('Y-m-d') : "",
                            'pReportStatus' => "U",
                            'pDeficiencyRemarks' => ""
                        ],
                        'MEDHISTS' => [
                            'MEDHIST' => $medhistory->toArray() ? [$medhistory->toArray()] : [$medhistoryDefault]
                        ],
                        'MHSPECIFICS' => [
                            'MHSPECIFIC' => $medhistorySpecific->toArray() ? [$medhistorySpecific->toArray()] : [$medhistorySpecificDefault]
                        ],
                        'SURGHISTS' => [
                            'SURGHIST' => $surgical->toArray() ? [$surgical->toArray()] : [$surgicalDefault]
                        ],
                        'FAMHISTS' => [
                            'FAMHIST' => $familyHistory->toArray() ? [$familyHistory->toArray()] : [$familyHistoryDefault]
                        ],
                        'FHSPECIFICS' => [
                            'FHSPECIFIC' => $familyHistorySpecific->toArray() ? [$familyHistorySpecific->toArray()] : [$familyHistorySpecificDefault]
                        ],
                        'SOCHIST' => [
                            '_attributes' => [
                                'pIsSmoker'=>$socialHistory ? $socialHistory->smoking : "",
                                'pNoCigpk'=>$socialHistory ? $socialHistory->pack_per_year : "",
                                'pIsAdrinker'=>$socialHistory ? $socialHistory->alcohol : "",
                                'pNoBottles'=>$socialHistory ? $socialHistory->bottles_per_day : "",
                                'pIllDrugUser'=>$socialHistory ? $socialHistory->illicit_drugs : "",
                                'pIsSexuallyActive'=>$socialHistory ? $socialHistory->sexually_active : "",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ],
                        'IMMUNIZATIONS' => [
                            'IMMUNIZATION' => [
                                '_attributes' => [
                                    'pChildImmcode'=>"C01",
                                    'pYoungwImmcode'=>"",
                                    'pPregwImmcode'=>"",
                                    'pElderlyImmcode'=>"",
                                    'pOtherImm'=>"",
                                    'pReportStatus'=>"U",
                                    'pDeficiencyRemarks'=>""
                                ]
                            ]
                        ],
                        'MENSHIST' => [
                            '_attributes' => [
                                'pMenarchePeriod'=>$menstrualHistory ? $menstrualHistory->menarche : "",
                                'pLastMensPeriod'=>$menstrualHistory ? $menstrualHistory->lmp : "",
                                'pPeriodDuration'=>$menstrualHistory ? $menstrualHistory->period_duration : "",
                                'pMensInterval'=>$menstrualHistory ? $menstrualHistory->cycle : "",
                                'pPadsPerDay'=>$menstrualHistory ? $menstrualHistory->pads_per_day : "",
                                'pOnsetSexIc'=>$menstrualHistory ? $menstrualHistory->onset_sexual_intercourse : "",
                                'pBirthCtrlMethod'=>$menstrualHistory ? $menstrualHistory->method : "",
                                'pIsMenopause'=>$menstrualHistory ? $menstrualHistory->menopause ? "Y" : "N" : "",
                                'pMenopauseAge'=>$menstrualHistory ? $menstrualHistory->menopause ? $menstrualHistory->menopause_age : "" : "",
                                'pIsApplicable'=>$menstrualHistory ? $patient->gender == 'F' ? "Y" : "N" : "N",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ],
                        'PREGHIST' => [
                            '_attributes' => [
                                'pPregCnt'=>"0",
                                'pDeliveryCnt'=>"0",
                                'pDeliveryTyp'=>"X",
                                'pFullTermCnt'=>"0",
                                'pPrematureCnt'=>"0",
                                'pAbortionCnt'=>"0",
                                'pLivChildrenCnt'=>"0",
                                'pWPregIndhyp'=>"N",
                                'pWFamPlan'=>"N",
                                'pIsApplicable'=>"N",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ],
                        'PEPERT' => [
                            '_attributes' => [
                                'pSystolic'=>$vitals ? $vitals->bp_systolic : "",
                                'pDiastolic'=>$vitals ? $vitals->bp_diastolic : "",
                                'pHr'=>$vitals ? $vitals->patient_heart_rate : "",
                                'pRr'=>$vitals ? $vitals->patient_respiratory_rate : "",
                                'pTemp'=>$vitals ? $vitals->patient_temp : "",
                                'pHeight'=>$vitals ? $vitals->patient_height : "",
                                'pWeight'=>$vitals ? $vitals->patient_weight : "",
                                'pBMI'=>$vitals ? $vitals->patient_bmi : "",
                                'pZScore'=>"",
                                'pLeftVision'=>"",
                                'pRightVision'=>"",
                                'pLength'=>$vitals ? $vitals->patient_height : "",
                                'pHeadCirc'=>$vitals ? $vitals->patient_head_circumference : "",
                                'pSkinfoldThickness'=>$vitals ? $vitals->patient_skinfold_thickness : "",
                                'pWaist'=>$vitals ? $vitals->patient_waist : "",
                                'pHip'=>$vitals ? $vitals->patient_hip : "",
                                'pLimbs'=>$vitals ? $vitals->patient_limbs : "",
                                'pMidUpperArmCirc'=>$vitals ? $vitals->patient_muac : "",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ],
                        'BLOODTYPE' => [
                            '_attributes' => [
                                'pBloodType'=>$patient->blood_type_code,
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ],
                        /*'PEGENSURVEY' => [
                            '_attributes' => [
                                'pGenSurveyId'=>"1",
                                'pGenSurveyRem'=>"",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ],
                        'PEMISCS' => [
                            'PEMISC' => [
                                '_attributes' => [
                                    'pSkinId'=>"",
                                    'pHeentId'=>"",
                                    'pChestId'=>"",
                                    'pHeartId'=>"",
                                    'pAbdomenId'=>"",
                                    'pNeuroId'=>"",
                                    'pRectalId'=>"",
                                    'pGuId'=>"",
                                    'pReportStatus'=>"U",
                                    'pDeficiencyRemarks'=>""
                                ],
                            ],
                        ],
                        'PESPECIFIC' => [
                            '_attributes' => [
                                'pSkinRem'=>"",
                                'pHeentRem'=>"",
                                'pChestRem'=>"",
                                'pHeartRem'=>"",
                                'pAbdomenRem'=>"",
                                'pNeuroRem'=>"",
                                'pRectalRem'=>"",
                                'pGuRem'=>"SAMPLE REMARKS",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ],
                        'NCDQANS' => [
                            '_attributes' => [
                                'pQid1_Yn'=>"",
                                'pQid2_Yn'=>"",
                                'pQid3_Yn'=>"",
                                'pQid4_Yn'=>"",
                                'pQid5_Ynx'=>"",
                                'pQid6_Yn'=>"",
                                'pQid7_Yn'=>"",
                                'pQid8_Yn'=>"",
                                'pQid9_Yn'=>"",
                                'pQid10_Yn'=>"",
                                'pQid11_Yn'=>"",
                                'pQid12_Yn'=>"",
                                'pQid13_Yn'=>"",
                                'pQid14_Yn'=>"",
                                'pQid15_Yn'=>"",
                                'pQid16_Yn'=>"",
                                'pQid17_Abcde'=>"",
                                'pQid18_Yn'=>"",
                                'pQid19_Yn'=>"",
                                'pQid19_Fbsmg'=>"",
                                'pQid19_Fbsmmol'=>"",
                                'pQid19_Fbsdate'=>"",
                                'pQid20_Yn'=>"",
                                'pQid20_Choleval'=>"",
                                'pQid20_Choledate'=>"",
                                'pQid21_Yn'=>"",
                                'pQid21_Ketonval'=>"",
                                'pQid21_Ketondate'=>"",
                                'pQid22_Yn'=>"",
                                'pQid22_Proteinval'=>"",
                                'pQid22_Proteindate'=>"",
                                'pQid23_Yn'=>"",
                                'pQid24_Yn'=>"",
                                'pReportStatus'=>"U",
                                'pDeficiencyRemarks'=>""
                            ]
                        ],*/
                    ];
                });
        $profile['PROFILE'] = [$data->toArray()];
        $result = new ArrayToXml($profile);
        return $result->dropXmlDeclaration()->toXml();
        //return $profile;
    }

    public function profilings($transmittalNumber = '', $patientId = [], $revalidate = false)
    {
        $profile = [];
        $data = Patient::query()
            ->with([
                'patientHistorySpecifics',
                'familyHistory:patient_id,medical_history_id',
                'familyHistorySpecifics',
                'surgicalHistory',
                'socialHistory',
                'menstrualHistory',
            ])
            ->withWhereHas('patientHistory:patient_id,medical_history_id')
            ->withWhereHas('philhealthLatest', fn($query) => [
                $query->whereIn('membership_type_id', ['MM', 'DD']),
                $query->when($revalidate, fn($query) => $query->where('transmittal_number', $transmittalNumber))
            ])
            ->when(!empty($patientId), fn($query) => $query->whereIn('id', $patientId))
            //->whereId('97a9157e-2705-4a10-b68d-211052b0c6ac')
            ->get();
        $profileResource = ProfileResource::collection($data->whenEmpty(fn() => [[]]));

        $profile['PROFILE'] = [$profileResource->resolve()];
        /*$result = new ArrayToXml($profile);
        return $result->dropXmlDeclaration()->toXml();*/
        return $profile;
        //return count($profile['PROFILE'][0]);
    }

    public function soaps($transmittalNumber = '', $patientId = [], $tranche = 2, $revalidate)
    {
        $soap = [];
        $data = [];
        $medicine = [];
        if($tranche == 2){
            $data = Consult::query()
                ->with(['patient', 'vitalsLatest', 'consultLaboratory'])
                ->withWhereHas('finalDiagnosis')
                ->withWhereHas('philhealthLatest', fn($query) => $query->whereIn('membership_type_id', ['MM', 'DD']))
                ->when($revalidate, fn($query) => $query->where('transmittal_number', $transmittalNumber))
                ->when($revalidate == false, fn($query) => $query->whereNull('transmittal_number'))
                ->whereFacilityCode(auth()->user()->facility_code)
                ->wherePtGroup('cn')
                ->when(!empty($patientId), fn($query) => $query->whereIn('patient_id', $patientId))
                ->get();
                //->wherePatientId('97a9157e-2705-4a10-b68d-211052b0c6ac')

            $medicine = MedicinePrescription::query()
                ->whereIn('consult_id', $data->pluck('id'))
                ->withSum('dispensing', 'dispense_quantity')
                ->withSum('dispensing', 'unit_price')
                ->withSum('dispensing', 'total_amount')
                ->with('dispensing', 'user')
                ->get();
            //$data->map(fn($data, $key) => $data->update(['transmittal_number' => $transmittalNumber]));

        }
        $soapResource = ConsultationResource::collection(!empty($data) ? $data->whenEmpty(fn() => [[]]) : [[]]);
        $medicineResource = MedicineResource::collection(!empty($medicine) ? $medicine->whenEmpty(fn() => [[]]) : [[]]);

        $soap[0]['SOAP'] = [$soapResource->resolve()];
        $soap[1]['MEDICINE'] = [$medicineResource->resolve()];
        /*$result = new ArrayToXml($soap);
        return $result->dropXmlDeclaration()->toXml();*/
        return $soap;
    }
}
