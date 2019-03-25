<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ModelService as ModelService;
use App\Services\CarService as CarService;
use App\Http\Requests\ModelFormRequest;
use Cookie;

class CarModelController extends Controller {

    protected $carmodel;
    protected $years;
    protected $cars;

    public function __construct(ModelService $carmodel, CarService $cars) {
        $this->carmodel = $carmodel;
        $this->cars = $cars;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $carmodel = $this->carmodel->find($id);
        $cartrim = $carmodel[0]->carTrim;
        $result['year'] = $cartrim;
        $data = Cookie::get('booking');
        $data['carmodel'] = $id;
        Cookie::queue('booking', $data, 60);
        if (count($cartrim) > 0 && $cartrim != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

}
