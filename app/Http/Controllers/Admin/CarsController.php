<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CarService as CarService;
use App\Http\Requests\CarFormRequest;
use App\Http\Requests\updateCarRequest;
use Request as RequestFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CarsController extends Controller
{
        protected $cars;
        protected $table = 'Car' ;

        public function __construct(CarService $cars)
        {
            $this->cars  = $cars;
        }

            /**
            * Display a listing of the resource.
            *
            * @return Response
            */
       public function index()
       {
            $results['carResult'] = $this->cars->findAll();
            $results['page'] = 'cars';
            $results['page_number'] = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 0;
            if(RequestFacade::ajax()){
                return view('admin.car_table',$results);	
            }
            return view('admin.car',$results);
       }

       /**
            * Show the form for creating a new resource.
            *
            * @return Response
            */
       public function create()
       {

       }

        /**
             * Store a newly created resource in storage.
             *
             * @param  Request  $request
             * @return Response
             */
        public function store(CarFormRequest $request)
        {       
            $file_name = str_replace(" ", "", $_FILES['car_image']['name']);
            $brand_name = str_replace(" ", "-", $request->brand);
            $image_name = Date("dhis")."_".$brand_name."_".$file_name;
            $dirPath = public_path().'/images/car_image/';
            if (!file_exists($dirPath) && !is_dir($dirPath)) {
                $oldmask = umask(0);
                mkdir($dirPath) ;
                umask($oldmask);
            } 
            $path = $dirPath.$image_name;
            if(move_uploaded_file($_FILES['car_image']['tmp_name'],$path)){
                $image_url = '/images/car_image/'.$image_name;
            } else {
                $image_url = "";
            }
            $cars = [
                'brand'         => $request->brand,
                'description'   => $request->description,
                'image_url'     => $image_url,
                'remember_token'=> $request->_token
                ];
            try {
                $result = $this->cars->create($cars);
            }  catch (QueryException $ex) {
                return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->duplicate ],$this->badRequest);
            }
            
            if($result){
                return $this->getResponse($this->successStatusTxt,$this->table.$this->inserted);
            }
        }

        /**
             * Display the specified resource.
             *
             * @param  int  $id
             * @return Response
             */
        public function show($id)
        {       
             $cars = $this->cars->find($id);
             $result['cars'] = $cars;
             if(count($result)>0 && $result != []){
                return response()->json(['status' => 'success' , 'result' => $result],200);
             }else{
                return response()->json(['status' => 'error' , 'result' => $result],$this->notFoundCode);
             }
        }

        /**
             * Show the form for editing the specified resource.
             *
             * @param  int  $id
             * @return Response
             */
        public function edit($id)
        {
                //
        }

        /**
        * Update the specified resource in storage.
        *
        * @param  Request  $request
        * @param  int  $id
        * @return Response
        */
        
        public function update(updateCarRequest $request, $id)
        {   
            $file_name  = str_replace(" ", "", $_FILES['car_image']['name']);
            $brand_name = str_replace(" ", "-", $request->brand);
            $image_name = Date("dhis")."_".$brand_name."_".$file_name;
            $dirPath = public_path().'/images/car_image/';
            if (!file_exists($dirPath) && !is_dir($dirPath)) {
                $oldmask = umask(0);
                mkdir($dirPath);
                umask($oldmask);
            }
            if(move_uploaded_file($_FILES['car_image']['tmp_name'],$dirPath.$image_name)){
                $image_url = '/images/car_image/'.$image_name;
                $cars = [
                'brand'         => $request->brand,
                'description'   => $request->description,
                'image_url'     => $image_url,
                'remember_token'=> $request->_token
                ];
            } else {
                $cars = [
                'brand'         => $request->brand,
                'description'   => $request->description,
                'remember_token'=> $request->_token
                ];
            }
            try {
                $result = $this->cars->update($cars,$id);
            } catch (ModelNotFoundException $ex) {
                return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->failedMessage],$this->notFoundCode);
            } catch (QueryException $ex) {
                return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->duplicate ],$this->badRequest);
            } 
            
            if($result){
                return $this->getResponse($this->successStatusTxt,$this->table.$this->updated);
            }
        }

        /**
             * Remove the specified resource from storage.
             *
             * @param  int  $id
             * @return Response
             */
        public function destroy($id)
        {        
            try {
                $result = $this->cars->destroy($id);
            } catch (ModelNotFoundException $ex) {
                return response()->json(['status'=>$this->failedStatusTxt, 'message' =>  $this->failedMessage ],$this->notFoundCode);
            }catch (\Exception $ex) {
                return response()->json(['status'=>$this->failedStatusTxt, 'message' =>  $this->cantDelete ],$this->badRequest);
            }
            
            if($result){
                return $this->getResponse($this->successStatusTxt,$this->table.$this->deleted);
            }
        }	
           
}
