<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\YearService as YearService;
use App\Http\Requests\YearsFormRequest;
use App\Http\Requests\updateYearRequest;

class YearController extends Controller {

    protected $years;

    public function __construct(YearService $years) {
        $this->years = $years;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result = $this->years->findAll();
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
    public function store(YearsFormRequest $request) {
        $result = $this->years->create($request->all());
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Car bought Years is added Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Year is not added', 'error' => $result], 400);
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
        $result = $this->years->update($request->all(), $id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Car bought Years is updated Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Car bought Years is not updated', 'error' => $result], 404);
        }
    }

    public function show($id) {
        $result = $this->years->find($id);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'failed', 'result' => $result], 404);
        }
    }

    public function destroy($id) {
        $result = $this->years->destroy($id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Car bought Years is deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Car bought Years is not deleted', 'error' => $result], 404);
        }
    }

}
