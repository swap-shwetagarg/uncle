<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SubServiceOptService as SubServiceOptService;
use App\Services\SubServiceService as SubServiceService;
use App\Http\Requests\SubServicesOptFormRequest;
use Request as RequestFacade;
use App\Services\ServiceTypeService as ServiceTypeService;
use App\Services\CarServiceService as CarServiceService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class SubServiceOptController extends Controller {

    protected $subservicesopt;
    protected $subservices;
    protected $servicetype;
    protected $table = 'Sub Service Option' ;

    public function __construct(SubServiceOptService $subservicesopt, SubServiceService $subservices, ServiceTypeService $servicetype, CarServiceService $services) {
        $this->subservicesopt = $subservicesopt;
        $this->subservices = $subservices;
        $this->servicetype = $servicetype;
        $this->services = $services;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result['subServicesOpt'] = $this->subservicesopt->findAll(1);
        $result['subServices'] = $this->subservices->findAll(1);
        $result['servicesTypes'] = $this->servicetype->find(2);
        $result['inspection_services'] = $this->services->getInspectionServices();
        $result['page'] = 'subserviceopt';
        $result['page_number'] = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 0;
        if (RequestFacade::ajax()) {
            return view('admin.sub_services_options_table', $result);
        }
        return view('admin.sub_services_options', $result);
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
    public function store(SubServicesOptFormRequest $request) {
        $data_array = $request->all();
        $image_url = "";
        if (isset($_FILES['option_image']) && $_FILES['option_image']) {
            $file_name = str_replace(" ", "", $_FILES['option_image']['name']);
            $option_img_name = str_replace(" ", "-", Date('dmYhis'));
            $image_name = Date("d") . "_" . $option_img_name . "_" . $file_name;
            $dirPath = public_path() . '/images/option_images/';
            if (!file_exists($dirPath) && !is_dir($dirPath)) {
                $oldmask = umask(0);
                mkdir($dirPath);
                umask($oldmask);
            }
            $path = $dirPath . $image_name;
            if (move_uploaded_file($_FILES['option_image']['tmp_name'], $path)) {
                $image_url = '/images/option_images/' . $image_name;
            } else {
                $image_url = "";
            }
        }
        $recommend_service_id = implode(',', (isset($data_array['recommend_service_id']) && $data_array['recommend_service_id']) ? $data_array['recommend_service_id'] : []);
        $description = (isset($_REQUEST['option_description']) && $_REQUEST['option_description']) ? $_REQUEST['option_description'] : '';
        $data = [
            'sub_service_id' => $data_array['sub_service_id'],
            'sub_service_id_ref' => $data_array['sub_service_id_ref'],
            'recommend_service_id' => $recommend_service_id,
            'option_type' => $data_array['option_type'],
            'option_name' => $data_array['option_name'],
            'option_image' => $image_url,
            'option_description' => $description,
            'option_order' => $data_array['option_order'],
            'remember_token' => $data_array['_token'],
        ];
        
        try {
                $result = $this->subservicesopt->create($data);
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
        $result = $this->subservicesopt->find($id); 
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
    public function update(SubServicesOptFormRequest $request, $id) {
        $data_array = $request->all();
        $image_url = "";
        if (isset($_FILES['option_image']) && $_FILES['option_image']) {
            $file_name = str_replace(" ", "", $_FILES['option_image']['name']);
            $option_img_name = str_replace(" ", "-", Date('dmYhis'));
            $image_name = Date("d") . "_" . $option_img_name . "_" . $file_name;
            $dirPath = public_path() . '/images/option_images/';
            if (!file_exists($dirPath) && !is_dir($dirPath)) {
                $oldmask = umask(0);
                mkdir($dirPath);
                umask($oldmask);
            }
            $path = $dirPath . $image_name;
            if (move_uploaded_file($_FILES['option_image']['tmp_name'], $path)) {
                $image_url = '/images/option_images/' . $image_name;
                $data['option_image'] = $image_url;
            } else {
                $data['option_image'] = '';
            }
        }
        $recommend_service_id = implode(',', (isset($data_array['recommend_service_id']) && $data_array['recommend_service_id']) ? $data_array['recommend_service_id'] : []);
        $description = (isset($_REQUEST['option_description']) && $_REQUEST['option_description']) ? $_REQUEST['option_description'] : '';
        $data = [
            'sub_service_id' => $data_array['sub_service_id'],
            'sub_service_id_ref' => $data_array['sub_service_id_ref'],
            'recommend_service_id' => $recommend_service_id,
            'option_type' => $data_array['option_type'],
            'option_name' => $data_array['option_name'],
            'option_description' => $description,
            'option_order' => $data_array['option_order'],
            'remember_token' => $data_array['_token'],
        ];
        
        try {
                $result = $this->subservicesopt->update($data, $id);
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
               $result = $this->subservicesopt->destroy($id);
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
