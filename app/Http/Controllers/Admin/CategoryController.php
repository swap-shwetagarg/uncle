<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CategoryService as CategoryService;
use App\Services\ServiceTypeService as ServiceTypeService;
use App\Http\Requests\CategoryFormRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Request as RequestFacade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CategoryController extends Controller {

    protected $category;
    protected $service_type;
    protected $table = 'Category' ;

    public function __construct(CategoryService $category, ServiceTypeService $service_type) {
        $this->category = $category;
        $this->service_type = $service_type;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $result['categories'] = $this->category->findAll();
        $result['service_type'] = $this->service_type->findAll(1);
        $result['page'] = 'category';
        $result['page_number'] = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 0;
        if (RequestFacade::ajax()) {
            return view('admin.category_table', $result);
        }
        return view('admin.category', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(CategoryFormRequest $request) {
        $data = [
            'service_type_id' => $request->service_type_id,
            'category_name' => $request->category_name,
            'remember_token' => $request->_token,
        ];
        
        try {
                $result = $this->category->create($data);
        }  catch (QueryException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->duplicate],$this->badRequest);
        }
        if ($result) {
            return $this->getResponse($this->successStatusTxt,$this->table.$this->inserted);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $result = $this->category->find($id);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result], 200);
        } else {
            return response()->json(['status' => 'error', 'result' => $result], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateCategoryRequest $request, $id) {
        
        try {
                $result = $this->category->update($request->all(), $id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->failedMessage],$this->notFoundCode);
        } catch (QueryException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' => $this->duplicate ],$this->badRequest);
        } 
        if ($result) {
            return $this->getResponse($this->successStatusTxt,$this->table.$this->updated);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
       
        try {
                 $result = $this->category->destroy($id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' =>  $this->failedMessage],$this->notFoundCode);
        }catch (\Exception $ex) {
            return response()->json(['status'=>$this->failedStatusTxt, 'message' =>  $this->cantDelete],$this->badRequest);
        }
        if ($result) {
            return $this->getResponse($this->successStatusTxt,$this->table.$this->deleted);
        } 
    }

}
