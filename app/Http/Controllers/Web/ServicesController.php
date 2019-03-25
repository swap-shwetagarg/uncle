<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Services\CarServiceService as CarServiceService;
use App\Services\CategoryService as CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceFormRequest;
use App\Http\Requests\updateServiceRequest;
use Cookie;

class ServicesController extends Controller {

    protected $services;
    protected $category;

    public function __construct(CarServiceService $services, CategoryService $category) {
        $this->services = $services;
        $this->category = $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $results = $this->services->find($id);
        $result = $results[0]->subservice;
        $data = Cookie::get('booking');
        $data['services'] = $id;
        Cookie::queue('booking', $data, 60);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

}
