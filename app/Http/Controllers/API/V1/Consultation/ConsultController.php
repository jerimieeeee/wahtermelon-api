<?php

namespace App\Http\Controllers\API\V1\Consultation;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Consultation\ConsultRequest;
use App\Http\Resources\API\V1\Consultation\ConsultResource;
use App\Models\V1\Consultation\Consult;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @authenticated
 * @group Consultation Information Management
 *
 * APIs for managing Patient Consultation information
 * @subgroup Patient Consultation
 * @subgroupDescription Patient Consultation management.
 */
class ConsultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @queryParam patient_id Identification code of the patient.
     * @queryParam pt_group Patient group. Example: cn
     * @queryParam sort string Sort consult_date. Add hyphen (-) to descend the list: e.g. consult_date. Example: consult_date
     * @queryParam consult_done Consultation Status. Example: 1
     * @queryParam id Consultation Status. Example: 1
     * @queryParam per_page string Size per page. Defaults to 15. To view all records: e.g. per_page=all. Example: 15
     * @queryParam page int Page to view. Example: 1
     * @apiResourceCollection App\Http\Resources\API\V1\Consultation\ConsultResource
     * @apiResourceModel App\Models\V1\Consultation\Consult paginate=15
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->per_page ?? self::ITEMS_PER_PAGE;

        $consult = QueryBuilder::for(Consult::class)
        ->when(isset($request->pt_group), function($q) use($request){
            $q->where('pt_group', $request->pt_group);
        })
        ->when(isset($request->patient_id), function($q) use($request){
            $q->where('patient_id', '=', $request->patient_id);
        })
        ->when(isset($request->consult_done), function($q) use($request){
            $q->where('consult_done', '=', $request->consult_done);
        })
        ->when(isset($request->id), function($q) use($request){
            $q->where('id', '=', $request->id);
        })
        ->with('user', 'patient', 'physician', 'vitals', 'consultNotes', 'consultNotes.complaints.libComplaints', 'consultNotes.initialdx.diagnosis', 'consultNotes.finaldx.libIcd10')

        ->defaultSort('consult_date')
        ->allowedSorts('consult_date');

        if ($perPage === 'all') {
            return ConsultResource::collection($consult->get());
        }

        return ConsultResource::collection($consult->paginate($perPage)->withQueryString());
    }

    /**
     * Store a newly created Consult resource in storage.
     *
     * @apiResourceAdditional status=Success
     * @apiResource 201 App\Http\Resources\API\V1\Consultation\ConsultResource
     * @apiResourceModel App\Models\V1\Consultation\Consult
     * @param ConsultRequest $request
     * @return JsonResponse
     */
    public function store(ConsultRequest $request)
    {
        $request['consult_done'] = 0;
        $data = Consult::query()
        ->when(request('pt_group') == 'cn', function ($q) use($request){
            return $q->create($request->validated())->consult_notes()->create($request->validated());
        })
        ->when(request('pt_group') != 'cn', function ($q) use($request){
            return $q->create($request->except(['physician_id', 'is_pregnant']));
        });

        return response()->json(['data' => $data], 201);
    }

    /**
     * Display the specified resource.
     * @queryParam pt_group Patient group. Example: cn
     * @queryParam consult_done Consultation Status. Example: 1
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ConsultRequest $request, $id)
    {
        Consult::findorfail($id)->update($request->only(['physician_id', 'consult_done', 'is_pregnant']));
        $data = Consult::findorfail($id);
        return response()->json(['data' => $data], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
