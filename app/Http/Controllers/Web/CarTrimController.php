<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CarTrimService as CarTrimService;
use App\Services\ModelService as ModelService;
use App\Http\Requests\CarTrimFormRequest;
use Cookie;

class CarTrimController extends Controller {

    protected $cartrim;
    protected $carmodel;

    public function __construct(CarTrimService $cartrim, ModelService $carmodel) {
        $this->cartrim = $cartrim;
        $this->carmodel = $carmodel;
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
            return response()->json(['status' => 'failed', 'result' => $result], 404);
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
        $data = Cookie::get('booking');
        $data['cartrim'] = $id;
        Cookie::queue('booking', $data, 60);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'failed'], 404);
        }
    }

}
