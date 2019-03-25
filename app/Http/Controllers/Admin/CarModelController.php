<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ModelService as ModelService;
use App\Services\CarService as CarService;
use App\Services\YearService as YearService;
use App\Http\Requests\ModelFormRequest;
use App\Http\Requests\updateModelRequest;
use Request as RequestFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CarModelController extends Controller {

    protected $carmodel;
    protected $years;
    protected $cars;
    protected $table = 'Car Model' ;

    public function __construct(ModelService $carmodel, CarService $cars, YearService $years) {
        $this->carmodel = $carmodel;
        $this->cars = $cars;
        $this->years = $years;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result['carModel'] = $this->carmodel->findAll();
        $result['carResult'] = $this->cars->findAll($flag=1);
        $result['page'] = 'carmodel';
        $result['page_number'] = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 0;
        if (RequestFacade::ajax()) {
            return view('admin.carmodel_table', $result);
        }
        return view('admin.carmodel', $result);
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
    public function store(ModelFormRequest $request) {
        $data = [
            'modal_name' => $request->modal_name,
            'year_id' => $request->year_id,
            'remember_token' => $request->_token,
        ];
        try {
                $result = $this->carmodel->create($data);
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
        $result['carmodel'] = $this->carmodel->find($id);
        $result['year'] = $result['carmodel'][0]->years;
        $result['cars'] = $result['year']->cars;
        $result['years'] = $result['cars']->years;
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
    public function update(updateModelRequest $request, $id) {
        try {
                $result = $this->carmodel->update($request->all(), $id);
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
            $result = $this->carmodel->destroy($id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' =>  $this->failedMessage],$this->notFoundCode);
        }catch (\Exception $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' =>  $this->cantDelete],$this->badRequest);
        }
        if ($result) {
            return $this->getResponse($this->successStatusTxt,$this->table.$this->deleted);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function getCarData($id) {
        $cars = $this->cars->find($id);
        $result = $cars[0]->years;

        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }
    
    public function getCarModal($id) {
        $years = $this->years->find($id);
        $result = $years[0]->model;

        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

}
