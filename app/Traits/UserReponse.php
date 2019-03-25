<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Traits;

/**
 * Description of UserReponse
 *
 * @author vishal
 */
trait UserReponse {

    public function logoutSuccessResponse() {
        return response()->json(['status' => 'success', 'message' => trans('customResponse.logoutSuccessResponse')]);
    }

    public function logoutFailedResponse() {
        return response()->json(['status' => 'failed', 'message' => trans('customResponse.logoutFailedResponse')], 500);
    }

    public function sessionDestroyed() {
        return response()->json(['status' => 'failed', 'message' => trans('customResponse.sessionDestroyed')], 401);
    }

    public function notFoundUser() {
        return [
            'email' => [
                trans('passwords.user')
            ]
        ];
    }

    public function notFoundOtp() {
        return [
            'messages' => trans('customResponse.otpIsExist')
        ];
    }

}
