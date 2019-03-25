<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\YearService as YearService;
use App\Services\CarService as CarService;
use App\Http\Requests\YearsFormRequest;
use App\Http\Requests\updateYearRequest;
use Request as RequestFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class YearController extends Controller {

    protected $years;
    protected $table = 'Car bought Years' ;

    public function __construct(YearService $years, CarService $cars) {
        $this->years = $years;
        $this->cars = $cars;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
        $result['years'] = $this->years->findAll();
        $result['cars'] = $this->cars->findAll($flag=1);
        $result['page'] = 'year';
        $result['page_number'] = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 0;
        if (RequestFacade::ajax()) {
            return view('admin.year_table', $result);
        }
        return view('admin.year', $result);
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
    public function store(YearsFormRequest $request) {
        $data = [
            'year' => $request->year,
            'car_id' => $request->car_id,
            'remember_token' => $request->_token
        ];
        try {
            $result = $this->years->create($data);
        }  catch (QueryException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->duplicate ],$this->badRequest);
        }
        
        if ($result) {
            return $this->getResponse($this->successStatusTxt,$this->table.$this->inserted);
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
    }

    public function update(updateYearRequest $request, $id) {
         try {
                $result = $this->years->update($request->all(), $id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->failedMessage],$this->notFoundCode);
        } catch (QueryException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->duplicate ],$this->badRequest);
        } 
        
        if ($result) {
            return $this->getResponse($this->successStatusTxt,$this->table.$this->updated);
        } 
    }

    public function show($id) {
        $result = $this->years->find($id);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], $this->notFoundCode);
        }
    }

    public function destroy($id) {
        
        try {
                $result = $this->years->destroy($id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' =>  $this->failedMessage ],$this->notFoundCode);
        }catch (\Exception $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' =>  $this->cantDelete ],$this->badRequest);
        }
        if ($result) {
            return $this->getResponse($this->successStatusTxt,$this->table.$this->deleted);
        } 
    }

}
