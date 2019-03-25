<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Facades\AppSettings;
use App\Services\ReferralService;

class ReferralController extends Controller {

    protected $user;
    protected $refer;

    public function __construct(UserService $user, ReferralService $refer) {
        $this->user = $user;
        $this->refer = $refer;
    }

    public function index() {
        $data['referrals'] = $this->refer->findAll();
        $data['page'] = 'referrals';
        return view('admin.referrals', $data);
    }

    public function referralSettings() {
        $data['referral_settings'] = $this->refer->getReferralSettings();
        $data['page'] = 'referrals';
        return view('admin.referral-settings', $data);
    }

    public function saveReferralSettings(Request $request) {
        $request_array = $request->all();
        $response = $this->refer->saveReferralSettings($request_array);
        if ($response) {
            return redirect('admin/referral-settings')->with('message', 'Referral Settings updated!');
        } else {
            return redirect('admin/referral-settings')->with('message', 'Referral Settings updation failed!');
        }
    }

}
