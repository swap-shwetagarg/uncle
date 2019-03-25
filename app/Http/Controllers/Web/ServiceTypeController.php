<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ServiceTypeService as ServiceTypeService;
use App\Http\Requests\ServiceTypeFormRequest;
use App\Http\Requests\updateServiceTypeRequest;
use Cookie;

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
        $result = $this->servicetype->findAll();
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $results = $this->servicetype->find($id);
        $result = $results[0]->category;
        $data = Cookie::get('booking');
        $data['servicetype'] = $id;
        Cookie::queue('booking', $data, 60);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

}
