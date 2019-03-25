<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CategoryService as CategoryService;
use App\Services\ServiceTypeService as ServiceTypeService;
use App\Http\Requests\CategoryFormRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Cookie;

class CategoryController extends Controller {

    protected $category;
    protected $service_type;

    public function __construct(CategoryService $category, ServiceTypeService $service_type) {
        $this->category = $category;
        $this->service_type = $service_type;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $results = $this->category->find($id);
        $result = $results[0]->service;
        $data = Cookie::get('booking');
        $data['category'] = $id;
        Cookie::queue('booking', $data, 60);
        if (count($results) > 0 && $results != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

}
