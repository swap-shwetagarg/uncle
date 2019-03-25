<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\CarServiceService as CarServiceService;
use App\Services\CategoryService as CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceFormRequest;
use App\Http\Requests\updateServiceRequest;
use Request as RequestFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ServicesController extends Controller {

    protected $services;
    protected $category;
    protected $table = 'Service' ;

    public function __construct(CarServiceService $services, CategoryService $category) {
        $this->services = $services;
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result['servicesResult'] = $this->services->findAll();
        $result['inspection_services'] = $this->services->getInspectionServices();
        $result['category'] = $this->category->findAll($flag = 1);
        $result['page'] = 'service';
        $result['page_number'] = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 0;
        if (RequestFacade::ajax()) {
            return view('admin.service_table', $result);
        }
        return view('admin.service', $result);
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
    public function store(ServiceFormRequest $request) {
        $data_array = $request->all();
        $recommend_service_id = implode(',', (isset($data_array['recommend_service_id']) && $data_array['recommend_service_id']) ? $data_array['recommend_service_id'] : [] );
        $description = (isset($_REQUEST['description']) && $_REQUEST['description']) ? $_REQUEST['description'] : '';
        $data = [
            'category_id' => $data_array['category_id'],
            'recommend_service_id' => $recommend_service_id,
            'title' => $data_array['title'],
            'description' => $description,
            'remember_token' => $data_array['_token']
        ];
        
        try {
                $result = $this->services->create($data);
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
        $result = $this->services->find($id);
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
    public function update(updateServiceRequest $request, $id) {
        $data_array = $request->all();      
        $recommend_service_id = implode(',', (isset($data_array['recommend_service_id']) && $data_array['recommend_service_id']) ? $data_array['recommend_service_id'] : [] );
        $description = (isset($_REQUEST['description']) && $_REQUEST['description']) ? $_REQUEST['description'] : '';
        $data = [
            'category_id' => $data_array['category_id'],
            'recommend_service_id' => $recommend_service_id,
            'title' => $data_array['title'],
            'description' => $description,
            'remember_token' => $data_array['_token']
        ];
        
        try {
                $result = $this->services->update($data, $id);
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
                $result = $this->services->destroy($id);
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
