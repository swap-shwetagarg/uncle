<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ZipCodeService as ZipCodeService;
use App\Http\Requests\ZipcodeRequest;
use Cookie;

class ZipCodeController extends Controller {

    protected $zipcode;

    public function __construct(ZipCodeService $zipcode) {
        $this->zipcode = $zipcode;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $result = $this->zipcode->find($id);
        $data['zipcode'] = $id;
        Cookie::queue('booking', $data, 60);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'failed'], 404);
        }
    }

}
