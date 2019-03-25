<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService as UserService;
use App\Services\UserRoleService;
use App\Http\Requests\UserProfileRequest;
use Request as RequestFacade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Response;
use App\Services\ZipCodeService;
use Illuminate\Http\Request;
use App\User;
use Session;
use Auth;

class UserController extends Controller {

    protected $user;
    protected $table = 'User';
    private $userRole;
    protected $zipcode;
    protected $userService;

    public function __construct(UserService $user, UserRoleService $userRole, ZipCodeService $zipcode, UserService $userService) {
        $this->user = $user;
        $this->userRole = $userRole;
        $this->zipcode = $zipcode;
        $this->userService = $userService;
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $result = $this->user->findAll();
        if (RequestFacade::ajax()) {
            return view('admin.user_table', ['result' => $result]);
        }
        return view('admin.user', ['result' => $result]);
    }

    public function show($id) {
        $result = $this->user->find($id);
        if (count($result) > 0 && $result != []) {
            return response()->json(['status' => 'success', 'result' => $result]);
        } else {
            return response()->json(['status' => 'failed', 'result' => $result, 'error' => 'Not Found'], $this->notFoundCode);
        }
    }

    public function update(UserProfileRequest $request, $id) {
        $data_array = $request->all();
        $file_name = str_replace(" ", "", $_FILES['profile_photo']['name']);
        $image_name = Date("dhis") . "_" . $file_name;
        $dirPath = public_path() . '/images/profile_photo/';
        if (!file_exists($dirPath) && !is_dir($dirPath)) {
            $oldmask = umask(0);
            mkdir($dirPath);
            umask($oldmask);
        }
        $path = $dirPath . $image_name;
        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $path)) {
            $image_url = '/images/profile_photo/' . $image_name;
        } else {
            $image_url = "";
        }
        unset($data_array['profile_photo']);
        $data_array['profile_photo'] = $image_url;

        try {
            $result = $this->user->update($data_array, $id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => $this->failedStatusTxt, 'message' => $this->failedMessage], $this->notFoundCode);
        } catch (QueryException $ex) {
            return response()->json(['status' => $this->failedStatusTxt, 'message' => $this->duplicate], $this->badRequest);
        }
        if ($result === true) {
            return $this->getResponse($this->successStatusTxt, $this->table . $this->updated);
        }
    }

    public function destroy($id) {
        try {
            $result = $this->user->destroy($id);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['status' => $this->failedStatusTxt, 'message' => $this->failedMessage], $this->notFoundCode);
        } catch (\Exception $ex) {
            return response()->json(['status' => $this->failedStatusTxt, 'message' => $this->cantDelete], $this->badRequest);
        }
        if (isset($result) && $result === true) {
            return $this->getResponse($this->successStatusTxt, $this->table . $this->deleted);
        }
    }

    // Get user By their type (Mechanic, User)
    public function getUserByType($userType = NULL) {
        if ($userType == "Mechanic") {
            $result['page'] = 'mechanic';
        } elseif ($userType == "Admin") {
            $result['page'] = 'admin';
        } else {
            $result['page'] = 'user';
        }
        $role = \App\Role::where('name', '=', $userType)->get();
        $users = \App\Role::find($role[0]['id']);
        $result['result'] = $users->user()->paginate(15);
        if (RequestFacade::ajax()) {
            return view('admin.user_table', $result);
        }
        return view('admin.user', $result);
    }

    public function updateUserRole($user_role, $user_id) {
        try {
            if ($user_role == "Admin")
                $role = \App\Role::where('name', '=', 'Admin')->first();
            else
                $role = \App\Role::where('name', '=', 'User')->first();
            $result = $this->userRole->update($role->id, $user_id);
            if ($result) {
                return response()->json(['status' => 'success', 'message' => 'Role Changed']);
            }
            return response()->json(['status' => 'Failed', 'message' => 'Some error occured while changing']);
        } catch (\Exception $ex) {
            return response()->json(['status' => $this->failedStatusTxt, 'message' => $this->cantDelete], $this->badRequest);
        }
    }

    public function viewProfile($user_id) {
        $result['profile'] = $this->user->find($user_id);
        $result['page'] = 'mechanic';
        return view('admin.mechanic-profile', $result);
    }

    public function exportUsers($userType = null) {
        ini_set('max_input_time', 2400);
        ini_set('max_execution_time', 2400);
        ini_set('memory_limit', '1073741824');

        $role = \App\Role::where('name', '=', $userType)->get();
        $user_obj = \App\Role::find($role[0]['id']);
        $users = $user_obj->user()->paginate(15000);

        $tot_record_found = 0;
        if (isset($users) && $users && count($users) > 0) {
            $tot_record_found = 1;

            //First Methos          
            $i = 1;
            $export_data = "S.No., Name, Email Address, Mobile Number, Default Location\n";
            foreach ($users as $user) {
                $export_data .= $i . ',' . $user['name'] . ',' . $user['email'] . ',' . $user['mobile_country_code'] . ' ' . $user['mobile'] . ',' . $user->getZipCode->zip_code . "\n";
                $i++;
            }
            return response($export_data)
                            ->header('Content-Type', 'application/csv')
                            ->header('Content-Disposition', 'attachment; filename="download.csv"')
                            ->header('Pragma', 'no-cache')
                            ->header('Expires', '0');
        }
        return view('download', ['record_found' => $tot_record_found]);
    }

    public function addUser($user_type = '') {
        $data['locations'] = $this->zipcode->findAll(1);
        $data['page'] = 'user';
        $data['user_type'] = $user_type;
        return view('admin.add-user', $data);
    }

    public function saveUser(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'mobile' => 'required|unique:users|numeric',
                    'email' => 'required|email|unique:users',
                    'password' => 'required',
                    'default_location' => 'required'
                        ]
        );
        if ($validator->fails()) {
            //return false;

            return redirect('admin/user/add/User')->with(['error_type' => 'danger', 'error_message' => "User's email address or mobile number already exists!"]);
        }
        $request_array = $request->all();
        $user = $this->userService->addUser($request_array);
        if ($user) {
            return redirect('admin/user/role/User')->with(['error_type' => 'success', 'error_message' => "User added successfully!"]);
        } else {
            return redirect('admin/user/add/User')->with(['error_type' => 'danger', 'error_message' => "User insertion failed!"]);
        }
    }

    // Inside User Controller
    public function user_switch_start($new_user) {
        try {
            if (Session::has('orig_user')) {
                return redirect()->intended('/user/dashboard');
            } else {
                $new_user_object = $this->user->find($new_user);
                Session::put('orig_user', Auth::id());
                Auth::login($new_user_object);
                return redirect()->intended('/user/dashboard');
            }
        } catch (\Exception $ex) {
            return redirect()->intended('/');
        }
    }

    public function searchUser($search_user = '') {
        $result['result'] = $this->user->searchUser($search_user);
        return view('admin.search_user_table', $result);
    }

}
