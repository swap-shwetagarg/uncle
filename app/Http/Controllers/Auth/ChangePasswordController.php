<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest as ChangePasswordRequest;
use App\Repositories\Users\UserRepository;

/**
 * Class ChangePasswordController.
 */
class ChangePasswordController extends Controller {

    /**
     * @var UserRepository
     */
    protected $user;

    /**
     * ChangePasswordController constructor.
     *
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user) {
        $this->user = $user;
    }

    /**
     * @param ChangePasswordRequest $request
     *
     * @return mixed
     */
    public function changePassword(ChangePasswordRequest $request) {
        $result = $this->user->changePassword($request->only('old_password', 'new_password'));
        if ($result) {
            return response()->json(['status' => 'success', "message" => "Password changed successfully"]);
        } else {
            return response()->json(['status' => 'error', "message" => "Failed to change password", 'password' => "Invalid old password"]);
        }
    }

}
