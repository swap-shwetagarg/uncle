<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CarService as CarService;
use App\Http\Requests\CarFormRequest;
use App\Http\Requests\updateCarRequest;

class CarsController extends Controller {

    protected $cars;

    public function __construct(CarService $cars) {
        $this->cars = $cars;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result = $this->cars->findAll(1);
        if($result->isNotEmpty()){
            $result = $result->map(function($item) {
                $item->image_url = url('/').'/'.$item->image_url;
                return $item;
            });
        }
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
    public function store(CarFormRequest $request) {
        $result = $this->cars->create($request->all());
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Car is added Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Car is not added', 'error' => $result], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $result = $this->cars->find($id);
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
    public function update(updateCarRequest $request, $id) {
        $result = $this->cars->update($request->all(), $id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Car is updated Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Car is not updated', 'error' => $result], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $result = $this->cars->destroy($id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Car is deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Car is not deleted', 'error' => $result], 404);
        }
    }

}
