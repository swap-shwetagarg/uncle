<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SubServiceService as SubServiceService;
use App\Services\CarServiceService as CarServiceService;
use App\Http\Requests\SubServicesFormRequest;
use App\Http\Requests\updateSubServiceRequest;
use Request as RequestFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class SubServiceTypeController extends Controller {

    protected $subservices;
    protected $service;
    protected $table = 'Sub Service' ;

    public function __construct(SubServiceService $subservices, CarServiceService $service) {
        $this->subservices = $subservices;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result['subServices'] = $this->subservices->findAll();
        $result['services'] = $this->service->findAll(1);
        $result['page'] = 'subservice';
        $result['page_number'] = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 0;
        if (RequestFacade::ajax()) {
            return view('admin.sub_services_table', $result);
        }
        return view('admin.sub_services', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(SubServicesFormRequest $request) {
        $data_array = $request->all();
        $description = (isset($_REQUEST['description']) && $_REQUEST['description']) ? $_REQUEST['description'] : '';
        $data = [
            'service_id' => $data_array['service_id'],
            'title' => $data_array['title'],
            'display_text' => $data_array['display_text'],
            'description' => $description,
            'order' => $data_array['order'],
            'selection_type' => $data_array['selection_type'],
            'optional' => (isset($data_array['optional']) && $data_array['optional']) ? $data_array['optional'] : 0,
            'remember_token' => $data_array['_token']
        ];
        try {
                $result = $this->subservices->create($data);
        }  catch (QueryException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->duplicate],$this->badRequest);
        }
        
        if ($result) {
            return $this->getResponse($this->successStatusTxt,$this->table.$this->inserted);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $result = $this->subservices->find($id);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(updateSubServiceRequest $request, $id) {
        $data_array = $request->all();
        $description = (isset($_REQUEST['description']) && $_REQUEST['description']) ? $_REQUEST['description'] : '';
        $data = [
            'service_id' => $data_array['service_id'],
            'title' => $data_array['title'],
            'display_text' => $data_array['display_text'],
            'description' => $description,
            'order' => $data_array['order'],
            'selection_type' => $data_array['selection_type'],
            'optional' => (isset($data_array['optional']) && $data_array['optional']) ? $data_array['optional'] : 0,
            'remember_token' => $data_array['_token']
        ];
        
        try {
                $result = $this->subservices->update($data, $id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->failedMessage],$this->notFoundCode);
        } catch (QueryException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->duplicate ],$this->badRequest);
        } 
        if ($result) {
            return $this->getResponse($this->successStatusTxt,$this->table.$this->updated);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        
        try {
                $result = $this->subservices->destroy($id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' =>  $this->failedMessage],$this->notFoundCode);
        }catch (\Exception $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' =>  $this->cantDelete],$this->badRequest);
        }
        if ($result) {
            return $this->getResponse($this->successStatusTxt,$this->table.$this->deleted);
        } 
    }

}
