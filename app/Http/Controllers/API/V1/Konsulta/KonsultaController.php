<?php

namespace App\Http\Controllers\API\V1\Konsulta;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\Konsulta\EnlistmentResource;
use App\Http\Resources\API\V1\Konsulta\KonsultaTransmittalResource;
use App\Http\Resources\API\V1\PhilHealth\GetTokenResource;
use App\Models\User;
use App\Models\V1\Konsulta\KonsultaTransmittal;
use App\Models\V1\Patient\Patient;
use App\Models\V1\Patient\PatientPhilhealth;
use App\Models\V1\PhilHealth\PhilhealthCredential;
use App\Services\PhilHealth\KonsultaService;
use App\Services\PhilHealth\SoapService;
use Exception;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Spatie\ArrayToXml\ArrayToXml;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Konsulta Information
 *
 * APIs for managing Konsulta Information
 * @subgroup Konsulta
 * @subgroupDescription Konsulta.
 */
class KonsultaController extends Controller
{
    public function index(SoapService $service, KonsultaService $konsultaService)
    {
        //return $service->soapMethod('extractRegistrationList', ['pStartDate' => '12/09/2022', 'pEndDate' => '12/31/2022']);
        $firstTranche = $konsultaService->generateXml();
        $data = $service->encryptData($firstTranche);
        return $service->soapMethod('validateReport', ['pReport' => $data, 'pReportTagging' =>1]);

    }

    /**
     * getToken
     *
     * @param SoapService $service
     * @return Exception|mixed
     */
    public function getToken(SoapService $service): mixed
    {
        $credentials = auth()->user()->konsultaCredential;
        $credentialsResource = GetTokenResource::make($credentials)->resolve();
        $result = $service->soapMethod('getToken', $credentialsResource);
        if(isset($result->success)) {
            $credentials->update(['token' => $result->result]);
            return response()->json([
                'message' => 'Successfully added the token in the database!'
            ], 201);
        }
        return response()->json($result, 200);;
    }

    /**
     * extractRegistrationList
     *
     * @queryParam pStartDate date Start date format mm/dd/YYYY. Example: 01/01/2022
     * @queryParam pEndDate date End date format mm/dd/YYYY. Example: 12/31/2022
     * @param Request $request
     * @param SoapService $service
     * @return Exception|mixed
     */
    public function extractRegistrationList(Request $request, SoapService $service): mixed
    {
        $list = $service->soapMethod('extractRegistrationList', $request->only('pStartDate', 'pEndDate'));
        $service->saveRegistrationList($list->ASSIGNMENT);
        return $list;
    }

    /**
     * isMemberDependentRegistered
     *
     * @queryParam pPIN string Patient PIN. Example: 0123456789123
     * @queryParam pType string Type. Example: MM
     * @param Request $request
     * @param SoapService $service
     * @return Exception|mixed
     */
    public function checkRegistered(Request $request, SoapService $service): mixed
    {
        return $service->soapMethod('isMemberDependentRegistered', $request->only('pPIN', 'pType'));
    }

    /**
     * isATCValid
     *
     * @queryParam pPIN string Patient PIN. Example: 0123456789123
     * @queryParam pATC string Type. Example: abcdefghij
     * @queryParam pEffectivityDate date End date format mm/dd/YYYY. Example: 01/01/2022
     * @param Request $request
     * @param SoapService $service
     * @return Exception|mixed
     */
    public function checkATC(Request $request, SoapService $service): mixed
    {
        return $service->soapMethod('isATCValid', $request->only('pPIN', 'pATC', 'pEffectivityDate'));
    }

    /**
     * Display a listing of the Konsulta Transmittal resource.
     *
     * @queryParam filter[tranche] string Filter by tranche. e.g. 1 or 2 Example: 1
     * @queryParam include string Relationship to view: e.g. facility,user Example: facility,user
     * @queryParam sort string Sort created_at. Add hyphen (-) to descend the list: e.g. created_at. Example: created_at
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\Konsulta\KonsultaTransmittalResource
     * @apiResourceModel App\Models\V1\Konsulta\KonsultaTransmittal paginate=15
     * @return ResourceCollection
     */
    public function validatedXml(): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $data = QueryBuilder::for(KonsultaTransmittal::class)
            ->whereNull('konsulta_transaction_number')
            ->allowedIncludes('facility', 'user')
            ->allowedFilters('tranche', 'xml_status')
            ->defaultSort('created_at')
            ->allowedSorts(['created_at']);
        if ($perPage === 'all') {
            return KonsultaTransmittalResource::collection($data->get());
        }

        return KonsultaTransmittalResource::collection($data->paginate($perPage)->withQueryString());
    }

    /**
     * Generate and Validate XML
     *
     * @queryParam transmittal_number string Filter by transmittal number. Example: RP9103406820230100001
     * @queryParam patient_id string Filter by transmittal number.
     * @queryParam tranche string Filter by trance number e.g. 1 or 2. Example: 1
     * @queryParam revalidate boolean Filter by revalidate e.g. 0 or 1. Example: 0
     * @return Exception|mixed
     */
    public function validateReport(Request $request, SoapService $service, KonsultaService $konsultaService): mixed
    {
        //return $service->httpClient();
        //return $service->soapMethod('checkUploadStatus', []);
        //$firstTranche = $konsultaService->generateXml();
        return $firstTranche = $konsultaService->createXml($request->transmittal_number?? "", $request->patient_id?? [], $request->tranche , $request->revalidate);
        //$data = $service->encryptData($firstTranche);
        //return $service->soapMethod('submitReport', ['pTransmittalID' => 'RP9103406820221200001', 'pReport' => $data, 'pReportTagging' =>1]);
        //$contents = Storage::disk('spaces')->get('Konsulta/DOH000000000005173/1P91034068_20230109_RP9103406820230100001.xml.enc');
        //return $service->soapMethod('validateReport', ['pReport' => $data, 'pReportTagging' => $request->tranche]);
    }

    /**
     * Submit Validated XML
     *
     * @queryParam transmittal_number string Filter by transmittal number. Example: RP9103406820230100001
     * @return Exception|mixed
     */
    public function submitXml(Request $request, SoapService $service, KonsultaService $konsultaService)
    {
        $transactionNumber = null;
        $data = KonsultaTransmittal::whereTransmittalNumber($request->transmittal_number)->first();
        $xmlEnc = Storage::disk('spaces')->get($data->xml_url);
        $submitted = $service->soapMethod('submitReport', ['pTransmittalID' => $data->transmittal_number, 'pReport' => $xmlEnc, 'pReportTagging' => $data->tranche]);
        if(isset($submitted->success) && !empty($submitted->uploadxmlresult)) {
            $transactionNumber = $submitted->uploadxmlresult->transactionno;
        }
        if(isset($submitted->transactionno)) {
            $transactionNumber = $submitted->transactionno;
        }
        $data->update(['konsulta_transaction_number' => $transactionNumber, 'xml_status' => 'S', 'xml_errors' => $submitted]);
        return $submitted;
    }

    /*public function generateXml(Request $request, KonsultaService $konsultaService)
    {
        return $e = $konsultaService->createXml($request->patientId?? [],$request->tranche);
    }*/

    public function sample()
    {
        /*$submitted = [
                    {
                        "success": true,
                        "message": "FILE UPLOADED SUCCESSFULLY WITH TRANSACTION NUMBER P9103406820221200127",
                        "xmlerrors": {
                                "errors": []
                        },
                        "encryptedxml": {
                                "docMimeType": "text/xml",
                            "hash": "8648e711a3ede7d21b3758d1d12cd4802afd3470df0533f1f03882c3bc89dbab",
                            "key1": "",
                            "key2": "",
                            "iv": "rfeBefVclkU8HXdJf6V2OQ==",
                            "doc": "aFC5nhCY2JvLvnRgsId+JfTkCIeRZZcH6SWKxWYGojDNJh6U0YOWsHbPPPnvYZscebZX46niZGXDMH+oyQMtm1fm008eM9KW5d1LPT1eAxQ23ko8uzYOIUnl1bti8Y6qcJTKe2DhbG6mScOZkyn1oOtQlOeSNxZJ9h3FWIKd0Mss/Vttexvmzpj62W+LnZu+LMqea2oTW8Dy+nqMZPma6gbaYOHPGyWg62acH5+EUFUpo1KG473emNLA6EieVQ45CkZsmV3XnIWx9KecRq6f5zhNyutk7WUY82yra0EIJhDE2RPSL+HzPaydOk7qWtjPTmBdO8i1lNTXyzDfgiGqRvGj0Fhoew66rlEhCHCJc+ssPUYccOUTuG7ss5njlZyqzNGGkeb9l6P9VrCwoPGLQrnDg2q8Jehm83LvgXQW/Bobf8OxTX6rcvgYgXMc77ZSqF5b1Opu4VyTQKhmRq8d8PGdAWrS5I7FEGP8G9GRtECBihvgCflbR1V0pEmHgMAF8XymuvMQlJaGDagb2hb/FH+KaGie5QekImDrbElYJxMsDvstildrF5XrbZiZ2biuFgLLElTlqW3RxlceXyKUPxUJgfmhK9XQBke2Z29FZtz33l+tzsLKcRJN6NM8ay7mBVmBRG+LuZap0LaDBVM/qMpaN9tPzJkOoTM/kildmqZnP4MfffyZtPpPLhjT+UHDdPegr95WYtxTEqnsW6d9oW4xKVYXLFcC9FY58mc6VcuWEi3wzJVWDSsQHPq/J5RAqjtpmsO1Mcz0Eae1i5SLqX0PIaSa3Jud3gcUjzn5xMnhOXES//LvUG6bFilz9MMaXUwYQuL5lFbuvW9y99eAFC5+s5bV0gM4SvDjd6+HmnAlHPRsXtlIU8or8QDBaktpDix2CRO9Si5sf4tu67DD82+KpPaab/qVXwW0LcCb4Av22QCJkx7pevXfEWabyaEug6C+gk9GttuFDvBM/fjAVKl/xP/NF2ixuw4hZuQPZf8aLmYQxqk7tjoaqHPnBcpxxNhE1A+5FLZRfkJNhCTqsXC3Ar+/x6Gms39b/E6LJY93enlWSh4rIeIU+p0AwPJIwffu/u8bNb6KmqxDCy1cCEfMUrrXqI0cLBBnn6cDmp9+zcm4G4ASyN9n0Fr7xc1A7VaZ+f/OntBQoSwu/GrS56UYOlH3XeS9n7Zpj8kUmT4y+SY7Tsvu99XkubjmbNG3drlhlGE7rEs/1X5XtHtBiPDQ5DrEz0taFYsDfnrM0kHmC5CBjHq1mF1h9Ew/Du68X9iPSSolt0wwSTc3wCf2m8FNFnXlMhc59DWRipa7t9nk0eveiMECHublG/7wxSuoATeU+sx9hx7NeuvL513iCnJ8rAfeX5kz00nY4MIDFKzx5EU3JvKysq4Glm3SPh5evwcMVwymVhus2PNlLMlMCGoTddVq8W8W4llzImccOAq6lBNIEpsH7RhiXp6wg7oF3970MIyn+TVLyE2attVIXgH8Qou0aMKCeFRnYQAJ0zvfffqIaFmA9imzqBPxB1SH9CsWrHSU+9wg4eMCGnoUKvk1eYQ0GBEMnTZW8D0cj6Jd2hxP1YGqf7gvd+P0j8BF79ZOjM0dNF0W6nzBu6TvFhch3doaR1fS6tkLRwblh3RrnKgtuTvSTAHgFAtXi1fSswJHTYBXjfW0BIIrdcqsyLVuaXS16PHph+LjfkfUo7vfGtM8S8fMszjbubOLToYIPWz0oVxYeVZkoA4QdZmH116DX0eaKE+BzmhvSxYRccNKd6EmBixZcI0HsqEi8e8WE1PXsDnvslX/7fyXnjjFdlZDYZg0CTk5soeXFst8X/p8zQWbnVH6oQdk4k17/KoZtqBFc3/V0osTxtNxNyn7ig6m5ev6kvqYKmRidSsgh1ogN8jbbNZv1n/Rohqwwv2zZbRQpzLx9CxCqaonG4Oo6WbgtOqyY3Crcl7aOaPEWjRhZRDTWBBXoVIupWMPFGMri9bOvchI/xGUdWsQfN7mwMLg1kApRknJ8Oz8/jc4hv8pZwEXiZppTHso2zULSVcEx/gRPIJrCs+SaKCvJbNLpLx/YjVqTjxVBejcK0A98/FjFYp+CSWStZC8l4iq+HcDcYxFg1XXKyAmB7LIFGyD0w04KbRifpdt+XZkOMOrrzfPCkkTgqnBSJWJ3zp0FnSobZ9Hhhv1VlG9xYb/uGaCBp2a+D06llya3co1FfCRlnpCKz2BKLIw9vluGYyDl8MD1HMspnBG0LvN+KJo4qOE6YVsroxSXfWHA7QkerNmVH+yCzvZ5cW8W8iklUlithjwsn21/+OXNe+m1X6SfzNHrjhb04K4j/XjuZoWBIO7q02aC1eJZ6Wp+ppwlnltCcj6VH/oWhUbc7noqfLXmHH5LKiAGI7nb4y5rQ5hTJaPu7cPR6qQLTx0zBFrCYele5Z4GPWmbw0pk/KWkWSFeoKC3DS/F2VEKyzJ4S/W1y49lNhNKWHWYSexhrjHJemS3i3e6UzGZIMQbrbZ2NtyvGATX2RTcMZ3/5nGDRb4o/hH/eIcjIAGr4Kyuz1MYYkxZ3dnioEgPSYrSu8B2GAX2TiczB9+Qq7HwiFFhhR5LS63Y1VQCdHBzwO4WMhf43vTHebXIxGg2MMsRuzf2n/T9mUUWEE4BO2HXcAFz4/tK06UAvrhN5ajsHxPnLkv6ayXME5ykJim8//NU/ka4nNf+Qxrj2zC/kEr6Oc2PzKAfD8PadhOMw1dvuBA63dwxJZn8ymekD//clc358r12NFdcvSI/KUqK6AeAPptkCrcMjkoi2aeLHQ9J18ZKXo0NjfdMpx9RJcZzM/NaXCGZtsfiC0q5gZVLXF0WBsXdvowDUsMvdkmdmrw+khvQPXNPovBNGF76YRGME4QsJeyb8rzzm2I8X5nAqVLTxOl3Op9015kCG57Tpxjn0S6rDC0tMkiK46QHYnRO+fygoOq5lOK0kOAV2Keyg2H7xjcT6rDaVAtqhc/tznUum7MsLNqTwZinvo8g+13/GPSQKS6dYUOfv3z138UzcqR9X5nI8xW0gp6rjmHkAtunsK5AMy4ZlPLmwGLmw0PkSO8DiZiNlUCxDTGaoq4+k+AgiTylHP/HstVreqwG+xfm1HWPXzjmQnm1LFF8RPd5hi7bnC4aIww+dwvmBNQW4+FZjrPYn8tHVDWxcZVQGZg74bfiF5bgysAY82QFPRS+Fh7/9GO5pSlz6RYRxh4BknipUGJa1Kn+pnK+rv4QB+CrWlz9xGDKIKRgn8Q3d9dpkVFMRUF9WRNTSLqZtzFIGgAFGQM6XrgPexOjvxw2WQgLxBcGeOcspn6t38nqqru6ggkZjYPbKZOp4bU9rBx4xMrGKuoD+3d08potPMC4HioMpyT2dssAzEU0GY+DptfoZuXjinowQrYJnZbgbF12snsi74pV2Gt3+a4D8XFXkEgvkv+8k6q9mLkHaDDt2gPiq9mPjyDbR2sRZ36ki2ZRDJRQnMhQI12rRGHuQGX/9I8VB7npUoW9AuSx9CxbJxDqqdiz2a07ZfI3DJdPsQlyaYub5LHfDQfx7GI5YoO7H3MFtpbcgnqTXJnUPBVVKQe9MSQmqKjtyw0OYV/g1BDEC855eJEZSllkH325/Y8gOl+A9hW1yI2Wo69C+5+8lWSpJf1jCKzrlTh/Li0tPAmk5L/puKt+vkqKln46o5Ls2RaAD5F97ZxpNOK8dWx2ZlSHj8wPPIrcml4xxlQh0j9Gax21BeoFFwIraPEvP4nDdSGO5cAcSwmtU7nwgzbyUDBDndZQtyaMFzmau61Yw2CuBRnmaqW3RRKYL7m33kZKTkHkgNX7WZpDdjmV4IMAf/2UR3w68Rq4Fc+ZnyR2X96l32ugRqU/+FPtYqRc58KvTEOgu0rFSrkDYjBIbX6m/e3MfbkGQoHxjBpwEnV47tZ7gqfs4a29q7oXlq4VKlAnLOhvlC00/j1cgww5mRziQmuK5E1mqVm18f4eC/9HiYhBxmBOEt0/ayWQopQF/h+hEG9QQQOSeKZfX+WqMe3nDB/M1ljmRzN5hNG6ZNLgzNOUM2EjQABn9j0bnHTrlbZOFwK8qvHBrht7FLqOBqZ4y6imddeyvt6lBY7DsCoBJct0xWTIRf5TzIBMzcE6a0up8tRTwb0oFrr6EuO+Xh3+siahjQdY06Ecj7cGDgJWOA0HRBBx6mtcvSGn7v+NZ3cn5z4fW1WktRLStggWNSI51GliMuxXKGx4sGi1V3TV48Ir6mMbVO5mguvvUTWOHswqpueqZmUWAFoEwDFXH3sAF6rleRrR68R/AR2bBJ4CG85NmLvylKfAx2YFK74RHIVvEKOCpnf9+vMqrPH6fPqq6dDf+CgLOJnz4USFLDQFUPXQ9oWwglCnbcTf93Kd+B2Ql3d6EK20plFQZ5Miz4/xE16DZouZSvk14XZwBGQnRHfYadw243p8c73+5jHQhab95o2EraZpgZD6D2HBkWsOB+7LfrfBsJFTQUUVDW//cmi14LUKVywLlGQ5fKxo1OtnPVY3BiOjGpfRLcEqX4K/+R+S9EsAQ1V3SHtCTBzFDxpMRfnyeSv4eFUrCat0N1ORwX01Cq5QQXw1j4Biq/pGlGHa8IFF8E/QIgHjKr7/WKa6CTsBDaRH+QCGnHi2SyAnnSUvFbElYIWpskJ0FMxbWBUs3ZWemx9Snr2br1TbBXtPzU331euZ3CYjg+nqOkmCkDiDI4/4wmuJ+gnvoNSIZg42rlumIa2Xq3Jvheln3RHS4bc3O76s36/awj+xCu1g/MrLYGu5uE5IFgk0HmXgLVt8oYXwqtwPl8QKAyly40BFtk60l8Ads99tFUU8vekcfAZD3KgKxQxd6PDAE4ShyYsLllLGFyo13ClwrGbpAFDP/ZdmsXkLRa0ZXvPFeem23SuLTumb7IZcLZqEMzayEoDl6c/3VCGJ5/Mh4BB9qtmxXFhN6nvF4CM61AM5KaKIfjwvI/ctdwidPqk0ekzZtyIlpI/YP7zXhkCM3vmUdIJnACh2wkBKh/4Ezw1CeC1D2XF5s2D5KJj0EErHlUoJ78TIhqlo+uPCWsgQiJQn/tIAzC3t8HN90aapOUgn1Ed0lWvgF/YMUhxK9vkhcjgOSOcJpxYt9Y6VwUHooy3CVSJU5cwTWyo/Jh8nukrLF3wA4YLKU9uxMTkrtcTMcsvBPIeqZICqj8E+NoRYxmg2eQRHoKJT69S3kQ1ppv9ixPuv/6SepinB2o82713iS6qOOItl4qF3j54Lio1Khg1Z5BKFjWxf7Jk/7bDfFTmcFgAht9PDOsTi9zqocLe5o58BIpxPhVhD3gs2cDfgV1LnsJdQJ32WCqeLGDup1ocQqK/BWP4IOoKnptFAuP7ZeraXw82gvHMntmXmlr6XzUwmm+8Uq3aiXgzzqaGWy2rTPFfKu3sLISQGMHtfofaQYDU4O3phD9QibdzwtJXv/LmK5WeXda4fWXXEYmWR+m+hWz5dzjVJxB35isx6ncWapPU8CeYXduyA/2DiOkNnZr6TBaq+cLCbXJGdHdXt7miODkHdsYYoh80CmLWDd+4pO504eDblEk8isDD7C/SYzrxa6n7hZoC2ZPqbCbdCAi/J3Pb54fGp4XfEYbDdUDDJHlqXhX7gV7kMJiOMT6RrJk4aqS+Vpfzf6cf/x+KWAWepcOcI7Em/Dz+BwM/icjAju6bhuiiCHo/kg/UfCBGkgK5YLjJD7eK3zr23EAJPZ7Dda+T2BCYJEEUtR9aNZbXBQ9Xd6zHQBUuvVnoYAnmoMheAdUjgLyuP+d1+leen8znlCmgGOdsbkolQHkl3NBC/UlFzVmoUliCDPssbM4pBZvQwIEQJ/zs2KQa0xL32lmF2DZZGJKOL2OcoUAHxOfBvep/DoPALJXTXldJd8hdgUDwdrO0T1F91GYXtoEGmenNiv7CkYxGHi/exmekZPpOo2AsR4wQcatFGpKCt1hFmqVP8Vqbf5KO3607WSRgXNrtfRRgTIbxFG1sTfkcoo+NwJkH1NkYfjnUnW23SMM6I29f4at/jgDGHD8TIYmqku9/l+C97lKhYZojQQDtSQxNq42itpSanvmJ+ljDEJPvp0wvLCwZsoQCgL34xqlqnOM47flq6ZpbDnXrAUpUYum7nQcocvC3/yjvgUZ32thj14agmttttEwtC+/oXnTlVea9dFOQvXQLFXNNUtyi76knyLwXxkEzsNRmAsyaScUNlEHLPmvBT98fJVbHeGYVRJzMiJn84rnvLRSqSB5qZDEC8R6kqzF0o0/D7MCxlwQSrH+H6/Z6DOkKkemAQ2pw20F09jXuDqI0jZr6j7dov7nWqPwICH82pw6+cT3UlmC0bZPWb0NMDrAu9zpxX6RjG+P8CMevaUc8/YTJZUXIYsw2pYLVuJZe4x15FJEIuNrg/4ekjGtkM2VcNgoDNuGnt2YQz/J3fi2UH/3kCNCuA/3vEHoHYguybemHcPxdiKz0XiOecZXtfaamzX2uYm9jX5q5WAU8EOvAVyWdjMt8dxW4s5vf9pddp8IVHV/E1oAQCKCFW7Khg5/Yj0AjF90EF07rtUmUx9FzDHbttNZb6dzuW09Uss8Qle/CGPa0lEGMFqZkv/RDACwlbZRmmynLsRjh8gNLk+WF0FY+rr+jkjV7Xg5MbGS1b3xZbvql8GN0yXYLjLp3JXPxBF60DW+Yr7WfatflvLZTveMLJmLTVch5WRDzSH2vw7SnwLHeuSjEkosfnkvRguQ1NDsf89TFKw7fs7ErpTZzM7+RLA3bfFg4tb2ABzms61i5GuYqe1EZT55sjzfjzcywR4P/L7WhbolNA54OIo6TMaEWEl/wgEYJ/+ZHsH0CSEPZGudhOvRq8rmxOMh1ouiqeMYLkLPUWZhsLX096NXk2BMbJSGVrjfRxiT/ykoxSu3RVulsclA/5FSxE42XQqyZWGVyABEaUoY/j1IXGQa7ZoFkiHDzchJDQb9PQEynFhip1c7zxsXV4xwlI0anRhTIGVbDy7n26r4TmC+jXq4kLQcZSnoBWgJkLGYXLtxpqVBh+2HBcPZWz2FK6FRcfpk9APF5KWA5ODp6KK6xIN5UwTHMTTJhnQdigRUtUf88XxmhDWnHDVU4De6LFXV1esXyk0ZyiRrUSO3Iscu28xeg3qawq89B1Xi6pbdzsmMQDoVo3u9dJqY0hWWFz84h0aeZAdJ33I5IgILtjfQVziSon03bjvCVS9fbcRE6n1nc2HNx9xUUNi7Wu4hIkhfZ/gdSeBNBosV9BpBC7PSddJReUx9O2QX6pzFRG9OZWXTa14FKI/pfjb+rjj6FtNT0SoTfkrDM28kvSQ3qM4+kHMP6CxJ+wYaASkzEdRf3wvZSmoI7j1Glh723rbHHUHNpTISNAEDAYXxiYV02typ6hbMJoRGitp5W8B2pgqH8pxP5U8xAbm7nlzNgT2zUrZsxTom4FlL3E62/o6dQKtefgZM00dq0oI5962Toh/Ailti8MoCoCn2gr+4N8YWjlQnPv4ea2Mn7zpvXSxW6Es1CKJwBIy0zrb94J8EKW2X/G7gYTb+TaQtnTjxcRPecGxt5qopECMitm7bXSXb6bYAMM0q88EVKuva79ssu3RwMcQBNgyek8y7KhqoYLZng+XJnl1meTNoMuwmBA2tVahqHamPuUQP/auTFoZey+vQDWF8ZbcKougnMnlId0OPOLKSnF2TckcONymQUEkoY+SZEZOFu2IeHsy+yrBuHFWUdh+rIKamcunDBWEIAiWjsclDMzPig0tGXEiJubRUpKgy4tmoGCaTTYcM8wYG6ICKQ05zY8gkBL3Z14zLmcgywu+XfJBFpBl0oWWJX4R2TEoCAafudmnnj8Et0ABtD3oNzX5usmc+hTGqKcjbUd0sZlQL69w4+BaKtA0u4nnt9861H+t1mY/roZSQ6ugYn0oC1BsgJF6e17qOTgUKT80ubehEjMGCmFhKJtKp57sQduBxbREstO+TmKu0Whs165TVeSKOvhoecSpBHGv8y1oStyy+P7fWjO6lQS9UHUqZAMA24IGafxmQ9s/LPTDn91cfJmU7zlDcQdNcpc9rNaSAWSz8vWUXCaO1ITq1Mda3ZtMLnyDDFE/Wn41eJA09zORTkBzZg1xuHdKCz0gtw2vgGUxRyk4Oe6PKR3E52zYJR8v5fBAb+Re4iWa+O/xYFVWAJ12dYY1MWbzIBqE/3wxZPYi5yB8bKCeRktLBsSzIAUy0VUUDrWGhrVo0uEHMP1cGKXhkWl/aX4283Xef8rmY9ASW9Hrl9XSSF6tNIVR7NiAoG8QIXsx6We+ITwl0RcKwgboty8zslsPhKtEXWIHUrHG/ozdwK118Qq5RGQgc37gwDbaVQLSVusPOeOmOTikjpiLice0mp6cNPySjlJLadFuOlLQp/z44UkPP1hnjGdoTlNLqZeYCEV/kjkxpR9/gdcXyzxGkXDFElD0gk5zTsDOokZ7STcGkzmgKUePfPeqvfqygBm+wzCCKKhInhrsR0xReJvlQJZOnsmphFsC80bdV0vybl6uUwzT6sWE5QPQrMNBMrjplDy87QX7lRs4eTDMH5jLmomgl80zgTTCD3kW9pWOOu0B8UNahpxH5Lgrc="
                        },
                        "encryptedxmlerrors": null,
                        "uploadxmlresult": {
                                "transactionno": "P9103406820221200127",
                            "userid": "java.lang.NullPointerException",
                            "dateuploaded": "12/21/2022",
                            "errors": null
                        },
                        "summary": {
                                "failed": "0",
                            "passed": "1",
                            "details": []
                        }
                    }
                ];*/
    }
}
