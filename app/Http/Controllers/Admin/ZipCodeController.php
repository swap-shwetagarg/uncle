<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ZipCodeService as ZipCodeService;
use App\Http\Requests\ZipcodeRequest;
use App\Http\Requests\updateZipRequest;
use Request as RequestFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ZipCodeController extends Controller
{
    protected $zipcode;
    protected $table = 'Location' ;

    public function __construct(ZipCodeService $zipcode)
    {
        $this->zipcode = $zipcode;
    }
        
        /**
        * Display a listing of the resource.
        *
        * @return Response
        */
       
       public function index()
       {
           $result['result'] = $this->zipcode->findAll();
           $result['page']  = 'zipcode';
           $result['page_number'] = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 0;
           if (RequestFacade::ajax()) {
               return view('admin.zip_code_table', $result);
           }
           return view('admin.zipcode', $result);
       }

       /**
        * Show the form for creating a new resource.
        *
        * @return Response
        */
       public function create()
       {
           return view('admin.zipcode');
       }

       /**
        * Store a newly created resource in storage.
        *
        * @param  Request  $request
        * @return Response
        */
       public function store(ZipcodeRequest $request)
       {  
           $data =[
                    'zip_code'    => $request->zip_code,
                    'country_code'=> $request->country_code,
                    'service_availability' => $request->service_availability,
                    'remember_token' => $request->_token,
                    'status'         => 1,
                ];
           try {
                $result = $this->zipcode->create($data);
            }  catch (QueryException $ex) {
                return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->duplicate],$this->badRequest);
            }
           
           if ($result === true) {
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
           $result = $this->zipcode->find($id);
           if (count($result)>0 && $result != []) {
               return response()->json(['status' => 'success', 'result' => $result], 200);
           } else {
               return $this->getResponse($this->failedStatusTxt,null,$this->notFoundCode);
           }
       }

       /**
        * Update the specified resource in storage.
        *
        * @param  Request  $request
        * @param  int  $id
        * @return Response
        */
       public function update(updateZipRequest $request, $id)
       {    
           try {
                $result = $this->zipcode->update($request->all(), $id);
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
       public function destroy($id)
       {
           try {
                $result = $this->zipcode->destroy($id);
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
