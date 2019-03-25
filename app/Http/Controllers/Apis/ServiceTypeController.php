<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ServiceTypeService as ServiceTypeService;
use App\Http\Requests\ServiceTypeFormRequest;
use App\Http\Requests\updateServiceTypeRequest;

class ServiceTypeController extends Controller {

    protected $servicetype;

    public function __construct(ServiceTypeService $servicetype) {
        $this->servicetype = $servicetype;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result = $this->servicetype->findAll(1);
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
    public function store(ServiceTypeFormRequest $request) {
        $result = $this->servicetype->create($request->all());
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Service Type is added Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Service Type is not added', 'error' => $result], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $result = $this->servicetype->find($id);
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
    public function update(updateServiceTypeRequest $request, $id) {
        $result = $this->servicetype->update($request->all(), $id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Service Type is updated Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Service Type is not updated'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $result = $this->servicetype->destroy($id);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Service Type is deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Service Type is not deleted'], 400);
        }
    }

}
