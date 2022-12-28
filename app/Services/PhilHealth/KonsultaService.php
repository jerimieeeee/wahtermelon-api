<?php

namespace App\Services\PhilHealth;

use Spatie\ArrayToXml\ArrayToXml;

class KonsultaService
{
    public function generateXml()
    {
        $root = [
            'rootElementName' => 'PCB',
            '_attributes' => [
                'pUsername'=>"", 'pPassword'=>"", 'pHciAccreNo'=>"P91034068", 'pPMCCNo'=>"Z10681", 'pEnlistTotalCnt'=>"1", 'pProfileTotalCnt'=>"1", 'pSoapTotalCnt'=>"1", 'pCertificationId'=>"KON-DUMMYSCERTZ10681", 'pHciTransmittalNumber'=>"RP9103406820221200001"
            ]
        ];
        $firstTrancheArray = [
            'ENLISTMENTS' => [
                'ENLISTMENT' => [
                    '_attributes' => [
                        'pHciCaseNo'=>"TH9000000120220800001",
                        'pHciTransNo'=>"PH9000000120220800001",
                        'pEffYear'=>"2022",
                        'pEnlistStat'=>"1",
                        'pEnlistDate'=>"2022-08-26",
                        'pPackageType'=>"K",
                        'pMemPin'=>"190269297550",
                        'pMemFname'=>"TFSHC FN ONE",
                        'pMemMname'=>"TFSHC MN ONE",
                        'pMemLname'=>"TFSHC LN ONE",
                        'pMemExtname'=>"",
                        'pMemDob'=>"1974-01-02",
                        'pPatientPin'=>"190269297550",
                        'pPatientFname'=>"TFSHC FN ONE",
                        'pPatientMname'=>"TFSHC MN ONE",
                        'pPatientLname'=>"TFSHC LN ONE",
                        'pPatientExtname'=>"",
                        'pPatientSex'=>"M",
                        'pPatientDob'=>"1974-01-02",
                        'pPatientType'=>"MM",
                        'pPatientMobileNo'=>"09090000000",
                        'pPatientLandlineNo'=>"",
                        'pWithConsent'=>"Y",
                        'pTransDate'=>"2022-08-26",
                        'pCreatedBy'=>"TEST01",
                        'pReportStatus'=>"U",
                        'pDeficiencyRemarks'=>""
                    ]
                ],
            ],
            'PROFILING' => [
                'PROFILE' => [
                    '_attributes' => [
                        'pHciTransNo'=>"PH9000000120220800001",
                        'pHciCaseNo'=>"TH9000000120220800001",
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
                            [
                                '_attributes' => [
                                    'pMdiseaseCode'=>"002", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                                ],
                            ]
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
                            'pIsSmoker'=>"N", 'pNoCigpk'=>"", 'pIsAdrinker'=>"N", 'pNoBottles'=>"", 'pIllDrugUser'=>"N", 'pIsSexuallyActive'=>"N", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'IMMUNIZATIONS' => [
                        'IMMUNIZATION' => [
                            '_attributes' => [
                                'pChildImmcode'=>"C01", 'pYoungwImmcode'=>"", 'pPregwImmcode'=>"", 'pElderlyImmcode'=>"", 'pOtherImm'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                            ]
                        ]
                    ],
                    'MENSHIST' => [
                        '_attributes' => [
                            'pMenarchePeriod'=>"0", 'pLastMensPeriod'=>"", 'pPeriodDuration'=>"0", 'pMensInterval'=>"0", 'pPadsPerDay'=>"0", 'pOnsetSexIc'=>"0", 'pBirthCtrlMethod'=>"", 'pIsMenopause'=>"", 'pMenopauseAge'=>"", 'pIsApplicable'=>"N", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'PREGHIST' => [
                        '_attributes' => [
                            'pPregCnt'=>"0", 'pDeliveryCnt'=>"0", 'pDeliveryTyp'=>"X", 'pFullTermCnt'=>"0", 'pPrematureCnt'=>"0", 'pAbortionCnt'=>"0", 'pLivChildrenCnt'=>"0", 'pWPregIndhyp'=>"N", 'pWFamPlan'=>"N", 'pIsApplicable'=>"N", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'PEPERT' => [
                        '_attributes' => [
                            'pSystolic'=>"95", 'pDiastolic'=>"58", 'pHr'=>"110", 'pRr'=>"30", 'pTemp'=>"36.10", 'pHeight'=>"0", 'pWeight'=>"8.9", 'pBMI'=>"0", 'pZScore'=>"", 'pLeftVision'=>"20", 'pRightVision'=>"20", 'pLength'=>"63", 'pHeadCirc'=>"46", 'pSkinfoldThickness'=>"46", 'pWaist'=>"48", 'pHip'=>"50", 'pLimbs'=>"40", 'pMidUpperArmCirc'=>"12.5", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'BLOODTYPE' => [
                        '_attributes' => [
                            'pBloodType'=>"B+", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'PEGENSURVEY' => [
                        '_attributes' => [
                            'pGenSurveyId'=>"1", 'pGenSurveyRem'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'PEMISCS' => [
                        'PEMISC' => [
                            '_attributes' => [
                                'pSkinId'=>"", 'pHeentId'=>"11", 'pChestId'=>"", 'pHeartId'=>"", 'pAbdomenId'=>"", 'pNeuroId'=>"", 'pRectalId'=>"", 'pGuId'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                            ]
                        ]
                    ],
                    'PESPECIFIC' => [
                        '_attributes' => [
                            'pSkinRem'=>"", 'pHeentRem'=>"", 'pChestRem'=>"", 'pHeartRem'=>"", 'pAbdomenRem'=>"", 'pNeuroRem'=>"", 'pRectalRem'=>"", 'pGuRem'=>"SAMPLE REMARKS", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'NCDQANS' => [
                        '_attributes' => [
                            'pQid1_Yn'=>"", 'pQid2_Yn'=>"", 'pQid3_Yn'=>"", 'pQid4_Yn'=>"", 'pQid5_Ynx'=>"", 'pQid6_Yn'=>"", 'pQid7_Yn'=>"", 'pQid8_Yn'=>"", 'pQid9_Yn'=>"", 'pQid10_Yn'=>"", 'pQid11_Yn'=>"", 'pQid12_Yn'=>"", 'pQid13_Yn'=>"", 'pQid14_Yn'=>"", 'pQid15_Yn'=>"", 'pQid16_Yn'=>"", 'pQid17_Abcde'=>"", 'pQid18_Yn'=>"", 'pQid19_Yn'=>"", 'pQid19_Fbsmg'=>"", 'pQid19_Fbsmmol'=>"", 'pQid19_Fbsdate'=>"", 'pQid20_Yn'=>"", 'pQid20_Choleval'=>"", 'pQid20_Choledate'=>"", 'pQid21_Yn'=>"", 'pQid21_Ketonval'=>"", 'pQid21_Ketondate'=>"", 'pQid22_Yn'=>"", 'pQid22_Proteinval'=>"", 'pQid22_Proteindate'=>"", 'pQid23_Yn'=>"", 'pQid24_Yn'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                        ]
                    ],
                ],
            ],
            'SOAPS' => [
                'SOAP' => [
                    '_attributes' => [
                        'pHciCaseNo'=>"", 'pHciTransNo'=>"", 'pSoapDate'=>"", 'pPatientPin'=>"", 'pPatientType'=>"", 'pMemPin'=>"", 'pEffYear'=>"", 'pATC'=>"", 'pIsWalkedIn'=>"", 'pCoPay'=>"", 'pTransDate'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                    ],
                    'SUBJECTIVE' => [
                        '_attributes' => [
                            'pIllnessHistory'=>"", 'pSignsSymptoms'=>"", 'pOtherComplaint'=>"", 'pPainSite'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'PEPERT' => [
                        '_attributes' => [
                            'pSystolic'=>"", 'pDiastolic'=>"", 'pHr'=>"", 'pRr'=>"", 'pTemp'=>"", 'pHeight'=>"", 'pWeight'=>"", 'pBMI'=>"", 'pZScore'=>"", 'pLeftVision'=>"", 'pRightVision'=>"", 'pLength'=>"", 'pHeadCirc'=>"", 'pSkinfoldThickness'=>"", 'pWaist'=>"", 'pHip'=>"", 'pLimbs'=>"", 'pMidUpperArmCirc'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'PEMISCS' => [
                        'PEMISC' => [
                            '_attributes' => [
                                'pSkinId'=>"", 'pHeentId'=>"", 'pChestId'=>"", 'pHeartId'=>"", 'pAbdomenId'=>"", 'pNeuroId'=>"", 'pGuId'=>"", 'pRectalId'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                            ]
                        ],
                    ],
                    'PESPECIFIC' => [
                        '_attributes' => [
                            'pSkinRem'=>"", 'pHeentRem'=>"", 'pChestRem'=>"", 'pHeartRem'=>"", 'pAbdomenRem'=>"", 'pNeuroRem'=>"", 'pRectalRem'=>"", 'pGuRem'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                        ]
                    ],
                    'ICDS' => [
                        'ICD' => [
                            '_attributes' => [
                                'pIcdCode'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                            ]
                        ],
                    ],
                    'DIAGNOSTICS' => [
                        'DIAGNOSTIC' => [
                            '_attributes' => [
                                'pDiagnosticId'=>"", 'pOthRemarks'=>"", 'pIsPhysicianRecommendation'=>"", 'pPatientRemarks'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                            ]
                        ],
                    ],
                    'MANAGEMENTS' => [
                        'MANAGEMENT' => [
                            '_attributes' => [
                                'pManagementId'=>"", 'pOthRemarks'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                            ]
                        ],
                    ],
                    'ADVICE' => [
                        '_attributes' => [
                            'pRemarks'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                        ]
                    ],
                ],
            ],
            'DIAGNOSTICEXAMRESULTS' => [
                'DIAGNOSTICEXAMRESULT' => [
                    [
                        '_attributes' => [
                        'pHciCaseNo'=>"TH9000000120220800001", 'pHciTransNo'=>"PH9000000120220800001", 'pPatientPin'=>"242500004774", 'pPatientType'=>"DD", 'pMemPin'=>"030263078507", 'pEffYear'=>"2022"
                        ],
                        'FBSS' => [
                            'FBS' => [
                                '_attributes' => [
                                    'pReferralFacility'=>"SAMPLE REFERRAL FACILITY", 'pLabDate'=>"2022-08-26", 'pGlucoseMg'=>"45", 'pGlucoseMmol'=>"7.8", 'pDateAdded'=>"2022-08-27", 'pStatus'=>"D", 'pDiagnosticLabFee'=>"0.00", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
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
                    ],
                    [
                        '_attributes' => [
                        'pHciCaseNo'=>"TH9000000120220800001", 'pHciTransNo'=>"PH9000000120220800001", 'pPatientPin'=>"242500004774", 'pPatientType'=>"DD", 'pMemPin'=>"030263078507", 'pEffYear'=>"2022"
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
                    ],
                ],

            ],
            'MEDICINES' => [
                'MEDICINE' => [
                    '_attributes' => [
                        'pHciCaseNo'=>"", 'pHciTransNo'=>"", 'pCategory'=>"", 'pDrugCode'=>"", 'pGenericCode'=>"", 'pSaltCode'=>"", 'pStrengthCode'=>"", 'pFormCode'=>"", 'pUnitCode'=>"", 'pPackageCode'=>"", 'pOtherMedicine'=>"", 'pRoute'=>"", 'pQuantity'=>"", 'pActualUnitPrice'=>"", 'pTotalAmtPrice'=>"", 'pInstructionQuantity'=>"", 'pInstructionStrength'=>"", 'pInstructionFrequency'=>"", 'pPrescribingPhysician'=>"", 'pIsDispensed'=>"", 'pDateDispensed'=>"", 'pDispensingPersonnel'=>"", 'pIsApplicable'=>"", 'pDateAdded'=>"", 'pReportStatus'=>"U", 'pDeficiencyRemarks'=>""
                    ]
                ],
            ],
        ];
        $result = new ArrayToXml($firstTrancheArray, $root);
        return $result->dropXmlDeclaration()->toXml();
    }
}
