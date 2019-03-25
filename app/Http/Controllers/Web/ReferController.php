<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Event;
use App\Services\UserService;
use App\Events\SendReferralEmail;
use App\Services\ReferralService;
use App\Models\Referral;

class ReferController extends Controller {

    protected $user;
    protected $refer;

    public function __construct(userService $user, ReferralService $refer) {
        $this->user = $user;
        $this->refer = $refer;
    }

    public function index() {        
        $name = Auth::user()->name;
        $url = $this->refer->getBase64Url(Auth::user()->id, Auth::user()->email);
        $referral_link = url('/register?' . $url);
        $referral_settings = $this->refer->getReferralSettings();
        if (isset($referral_settings) && $referral_settings && isset($referral_settings['referral_share_text']) && $referral_settings['referral_share_text']) {
            $referral_share_content = $referral_settings['referral_share_text'];
            $referral_share_content = str_replace("{USER_NAME}", $name, $referral_share_content);
            $referral_share_content = str_replace("{REFERRAL_SHARE_LINK}", $referral_link, $referral_share_content);
            $referral_settings['referral_share_text'] = $referral_share_content;
        }
        
        $url = $this->refer->getBase64Url(Auth::user()->id,Auth::user()->email);
        $referrals = $this->refer->getReferrallist(Auth::user()->id);
        return view('web.user.refer.refer_a_friend', ['referrals' => $referrals, 'referral_link' => url('/register?' . $url), 'user_name' => Auth::user()->name, 'page' => "refer", 'referral_settings' => $referral_settings ]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'referral_email' => 'required|emails',
        ]);
        $emails_arr = explode(',', $request["referral_email"]);
        $url = $this->refer->getBase64Url(Auth::user()->id,Auth::user()->email);
        Event::fire(new SendReferralEmail(['emails' => $emails_arr, 'referral_link' => url('/register?' . $url), 'user_name' => Auth::user()->name]));
        return response()->json(['status' => 'success','message' => 'Email sent successfully'],200);
    }
    
    public function getReferralLink() {
        $url = $this->refer->getBase64Url(Auth::user()->id,Auth::user()->email);
        return response()->json(['status' => 'success','referral_link' => url('/register?' . $url)]); 
    }
}
    