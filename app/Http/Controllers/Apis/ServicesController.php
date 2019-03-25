<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Services\CarServiceService as CarServiceService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceFormRequest;
use App\Http\Requests\updateServiceRequest;
use App\Facades\AppSettings;

class ServicesController extends Controller {

    protected $services;
    protected $category;

    public function __construct(CarServiceService $services) {
        $this->services = $services;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result = $this->services->findAll(1);
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
    public function store(ServiceFormRequest $request) {
        $result = $this->services->create($request->all());
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Service is added Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Service is not added'], 400);
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
        $result = $this->services->update($request->all(), $id);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Service is updated Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Service is not updated'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $result = $this->services->destroy($id);
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Service is deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Service is not deleted'], 400);
        }
    }

    // Services Counter
    public function serviceCounter() {
        $services_counter = AppSettings::get('services_counter');
        if ($services_counter) {
            return response()->json(['status' => 'success', 'counter' => (integer)$services_counter], 200);
        } else {
            return response()->json(['status' => 'error'], 400);
        }
    }

}
