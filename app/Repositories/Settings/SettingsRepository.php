<?php

namespace App\Repositories\Settings;

use App\Repositories\Settings\SettingsInterface;
use Illuminate\Support\Facades\Log;
use App\Facades\AppSettings;
use DB;

class SettingsRepository implements SettingsInterface {

    public function __construct() {
        
    }

    public function saveSettings($request_array = array()) {
    	if(isset($request_array['services_counter']) && $request_array['services_counter']) {
        	AppSettings::set('services_counter', ($request_array['services_counter'] + 1) );
    	}
    	if(isset($request_array['vat_tax'])) {
        	AppSettings::set('vat_tax', ($request_array['vat_tax']) );
    	}
        return true;
    }

}
