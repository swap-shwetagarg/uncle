<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CarTrimService as CarTrimService;
use App\Services\ModelService as ModelService;
use App\Http\Requests\CarTrimFormRequest;
use App\Http\Requests\updateCarTrimRequest;
use Request as RequestFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Services\CarService as CarService;

class CarTrimController extends Controller {

    protected $cartrim;
    protected $carmodel;
    protected $cars;
    protected $table = 'Car Trim' ;

    public function __construct(CarService $cars ,CarTrimService $cartrim, ModelService $carmodel) {
        $this->cartrim = $cartrim;
        $this->carmodel = $carmodel;
        $this->cars  = $cars;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result['cartrimResult'] = $this->cartrim->findAll();
        $result['carResult'] = $this->cars->findAll($flag=1);
        $result['page'] = 'cartrim';
        $result['page_number'] = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 0;
        if (RequestFacade::ajax()) {
            return view('admin.cartrim_table', $result);
        }
        return view('admin.cartrim', $result);
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
    public function store(CarTrimFormRequest $request) {
        $data = [
            'car_model_id' => $request->car_model_id,
            'car_trim_name' => $request->car_trim_name,
            'remember_token' => $request->_token,
        ];
        
        try {
                $result = $this->cartrim->create($data);
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
        $result = $this->cartrim->find($id);
        $car_data['car_id'] = $result[0]->carmodel->years->cars->id;
        $car_data['year_id'] = $result[0]->carmodel->years->id;
        $car_data['modal_id'] = $result[0]->carmodel->id;
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result,'car_data' => $car_data], 200);
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
    public function update(updateCarTrimRequest $request, $id) {
        
        try {
                $result = $this->cartrim->update($request->all(), $id);
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
                $result = $this->cartrim->destroy($id);
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
