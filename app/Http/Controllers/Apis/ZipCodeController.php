<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ZipCodeService as ZipCodeService;
use App\Http\Requests\ZipcodeRequest;
use App\Http\Requests\updateZipRequest;

class ZipCodeController extends Controller {

    protected $zipcode;

    public function __construct(ZipCodeService $zipcode) {
        $this->zipcode = $zipcode;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result = $this->zipcode->findAll(1);
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
    public function store(ZipcodeRequest $request) {
        $result = $this->zipcode->create($request->all());

        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Zipcode is added Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Zipcode is not added', 'error' => $result], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $result = $this->zipcode->find($id);
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
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(updateZipRequest $request, $id) {
        $result = $this->zipcode->update($request->all(), $id);

        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Zipcode is updated Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Zipcode is not updated', 'error' => $result], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $result = $this->zipcode->destroy($id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Zipcode is deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Zipcode is not deleted', 'error' => $result], 404);
        }
    }

}
