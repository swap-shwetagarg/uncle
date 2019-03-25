<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CarTrimService as CarTrimService;
use App\Http\Requests\CarTrimFormRequest;
use App\Http\Requests\updateCarTrimRequest;

class CarTrimController extends Controller {

    protected $cartrim;

    public function __construct(CarTrimService $cartrim) {
        $this->cartrim = $cartrim;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result = $this->cartrim->findAll();
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
    public function store(CarTrimFormRequest $request) {
        $result = $this->cartrim->create($request->all());
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Car Trim is added Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Car Trim is not added', 'error' => $result], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $result = $this->cartrim->find($id);
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
    public function update(updateCarTrimRequest $request, $id) {
        $result = $this->cartrim->update($request->all(), $id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Car Trim is updated Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Car Trim is not updated', 'error' => $result], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $result = $this->cartrim->destroy($id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Car Trim is deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Car Trim is not deleted', 'error' => $result], 404);
        }
    }

}
