<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller {

    public function getTermsAndConditions() {
        $data['page'] = Post::type('page')->slug('customer-terms-and-conditions')->first();
        return view('web.blocks.pages.customer-terms-and-conditions', $data);
    }

    public function getLimitedWarranty() {
        $data['page'] = Post::type('page')->slug('limited-warranty')->first();
        return view('web.blocks.pages.limited-warranty', $data);
    }

    public function getPrivacyPolicy() {
        $data['page'] = Post::type('page')->slug('privacy-policy')->first();
        return view('web.blocks.pages.privacy-policy', $data);
    }

    public function getTrademarkUsagePolicy() {
        $data['page'] = Post::type('page')->slug('trademark-usage-policy')->first();
        return view('web.blocks.pages.trademark-usage-policy', $data);
    }

    public function getTermsAndConditionsWeb() {
        $data['page'] = Post::type('page')->slug('customer-terms-and-conditions')->first();
        return view('web.blocks.pages.web.customer-terms-and-conditions', $data);
    }

    public function getLimitedWarrantyWeb() {
        $data['page'] = Post::type('page')->slug('limited-warranty')->first();
        return view('web.blocks.pages.web.limited-warranty', $data);
    }

    public function getPrivacyPolicyWeb() {
        $data['page'] = Post::type('page')->slug('privacy-policy')->first();
        return view('web.blocks.pages.web.privacy-policy', $data);
    }

    public function getTrademarkUsagePolicyWeb() {
        $data['page'] = Post::type('page')->slug('trademark-usage-policy')->first();
        return view('web.blocks.pages.web.trademark-usage-policy', $data);
    }
    
    public function getAboutUncleFitterWeb() {
        $data['page'] = Post::type('page')->slug('about-unclefitter')->first();
        return view('web.blocks.pages.web.about-unclefitter', $data);
    }
    
    public function getHowItWorksWeb() {
        $data['page'] = Post::type('page')->slug('how-it-works')->first();
        return view('web.blocks.pages.web.how-it-works', $data);
    }

}
