<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\YearService as YearService;
use App\Services\CarService as CarService;
use App\Http\Requests\YearsFormRequest;
use Cookie;

class YearController extends Controller {

    protected $years;

    public function __construct(YearService $years, CarService $cars) {
        $this->years = $years;
        $this->cars = $cars;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function show($id) {
        $results = $this->years->find($id);
        $carmodel = $results[0]->model;
        $result['years'] = $carmodel;
        $data = Cookie::get('booking');
        $data['years'] = $id;
        Cookie::queue('booking', $data, 60);
        if (count($carmodel) > 0 && $carmodel != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'failed', 'result' => $result], 404);
        }
    }

}
