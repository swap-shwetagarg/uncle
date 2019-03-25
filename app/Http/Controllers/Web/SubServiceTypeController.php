<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SubServiceService as SubServiceService;
use App\Services\CarServiceService as CarServiceService;
use App\Http\Requests\SubServicesFormRequest;
use App\Http\Requests\updateSubServiceRequest;
use Cookie;

class SubServiceTypeController extends Controller {

    protected $subservices;
    protected $service;

    public function __construct(SubServiceService $subservices, CarServiceService $service) {
        $this->subservices = $subservices;
        $this->service = $service;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $results = $this->subservices->find($id);
        $result = $results[0]->subserviceopt;
        $data = Cookie::get('booking');
        $data['subservices'] = $id;
        Cookie::queue('booking', $data, 60);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

}
