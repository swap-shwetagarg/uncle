<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SubServiceService as SubServiceService;
use App\Http\Requests\SubServicesFormRequest;
use App\Http\Requests\updateSubServiceRequest;

class SubServiceTypeController extends Controller {

    protected $subservices;
    protected $service;

    public function __construct(SubServiceService $subservices) {
        $this->subservices = $subservices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result = $this->subservices->findAll(1);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'failed'], 404);
        }
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
        $result = $this->subservices->create($request->all());
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Sub Service is added Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sub Service is not added'], 400);
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
        $result = $this->subservices->update($request->all(), $id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Sub Service is updated Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sub Service is not updated'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $result = $this->subservices->destroy($id);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Sub Service is deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Sub Service is not deleted'], 400);
        }
    }

}
