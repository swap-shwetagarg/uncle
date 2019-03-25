<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CarService as CarService;
use App\Services\ZipCodeService as ZipCodeService;
use App\Http\Requests\CarFormRequest;
use Cookie;

class CarsController extends Controller {

    protected $cars;
    protected $zipcode;

    public function __construct(CarService $cars, ZipCodeService $zipcode) {
        $this->cars = $cars;
        $this->zipcode = $zipcode;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $results['carResult'] = $this->cars->findAll();
        return response()->json(['result' => $results], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $cars = $this->cars->find($id);
        $years = $cars[0]->years;
        $result['years'] = $years;
        $data = Cookie::get('booking');
        $data['cars'] = $id;
        Cookie::queue('booking', $data, 60);
        if (count($years) > 0 && $years != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

}
