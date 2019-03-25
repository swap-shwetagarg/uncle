<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\UserAddressController;
use App\Services\AddressService as AddressService;
use App\Http\Requests\UserAddressRequest;
use Request as RequestFacade;
use Auth;

class UserAddressController extends Controller
{
            protected $useraddress;

            public function __construct(AddressService $useraddress)
            {
                $this->useraddress  = $useraddress;
            }
		
		/**
		* Display a listing of the resource.
		*
		* @return Response
		*/
	   public function index()
	   { 
              
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
	   public function store(UserAddressRequest $request)
	   {    
               $userId = Auth::id();
                $address = [
                    'user_id' => $userId,
                    'add_1'   => $request->add_1,
                    'add_2'   => $request->add_2,
                    'zipcode' => $request->zipcode,
                    'area'    => $request->area,
                    'country' => $request->country,
                    'remember_token'=> $request->_token,
                ];
                
                $result = $this->useraddress->create($address);
                if($result){
                    return response()->json(['status' => 'success','message' => 'Address is added Successfully'],200);
                }else{
                    return response()->json(['status' => 'error','message' => 'Address is not added'],400);
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
		   $address = $this->useraddress->find($id);
                   $result['address'] = $address;
		   if(count($result)>0 && $result != []){
		   		return response()->json(['status' => 'success' , 'result' => $result],200);
		   }else{
		   		return response()->json(['status' => 'error' , 'result' => $result],404);
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
	   public function update(UserAddressRequest $request, $id)
	   {    
                $result = $this->useraddress->update($request->all(),$id);
                if($result){
                            return response()->json(['status' => 'success','message' => 'Address is updated Successfully'],200);
                    }else{
                            return response()->json(['status' => 'error','message' => 'Address is not updated'],400);
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
                $result = $this->useraddress->destroy($id);
                if($result){
                            return response()->json(['status' => 'success','message' => 'Address is deleted Successfully'],200);
                    }else{
                            return response()->json(['status' => 'error','message' => 'Address is not deleted'],400);
                    }
	   }	
           
}
