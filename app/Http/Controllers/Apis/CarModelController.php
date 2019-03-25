<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ModelService as ModelService;
use App\Http\Requests\ModelFormRequest;
use App\Http\Requests\updateModelRequest;

class CarModelController extends Controller {

    protected $carmodel;

    public function __construct(ModelService $carmodel) {
        $this->carmodel = $carmodel;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result = $this->carmodel->findAll();
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
    public function store(ModelFormRequest $request) {
        $result = $this->carmodel->create($request->all());
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Car Model is added Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Car Model is not added', 'error' => $result], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $result = $this->carmodel->find($id);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'failed', 'result' => $result], 404);
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
        $result = $this->carmodel->update($request->all(), $id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Car Model is updated Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Car Model is not updated', 'error' => $result], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $result = $this->carmodel->destroy($id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Car Model is deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Car Model is not deleted', 'error' => $result], 404);
        }
    }

}
