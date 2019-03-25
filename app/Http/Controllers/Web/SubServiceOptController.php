<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SubServiceOptService as SubServiceOptService;
use App\Services\SubServiceService as SubServiceService;
use App\Http\Requests\SubServicesOptFormRequest;
use Cookie;

class SubServiceOptController extends Controller {

    protected $subservicesopt;
    protected $subservices;

    public function __construct(SubServiceOptService $subservicesopt, SubServiceService $subservices) {
        $this->subservicesopt = $subservicesopt;
        $this->subservices = $subservices;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $result = $this->subservicesopt->find($id);
        $data = Cookie::get('booking');
        $data['subservicesopt'] = $id;
        Cookie::queue('booking', $data, 60);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'failed'], 404);
        }
    }

}
