<?php

namespace App\Http\Controllers\Apis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SubServiceOptService as SubServiceOptService;
use App\Http\Requests\SubServicesOptFormRequest;

class SubServiceOptController extends Controller {

    protected $subservicesopt;

    public function __construct(SubServiceOptService $subservicesopt) {
        $this->subservicesopt = $subservicesopt;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result = $this->subservicesopt->findAll(1);
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
    public function store(SubServicesOptFormRequest $request) {
        $result = $this->subservicesopt->create($request->all());
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Sub Service option is added Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Sub Service option  is not added', 'error' => $result], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $result = $this->subservicesopt->find($id);
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
    public function update(SubServicesOptFormRequest $request, $id) {
        $result = $this->subservicesopt->update($request->all(), $id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Sub Service option  is updated Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Sub Service option  is not updated', 'error' => $result], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $result = $this->subservicesopt->destroy($id);
        if ($result === true) {
            return response()->json(['status' => 'success', 'message' => 'Sub Service option  is deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Sub Service option  is not deleted', 'error' => $result], 404);
        }
    }

}
