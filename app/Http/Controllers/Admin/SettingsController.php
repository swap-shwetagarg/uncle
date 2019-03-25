<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Facades\AppSettings;
use App\Services\SettingsService;

class SettingsController extends Controller {

	protected $refer;

    public function __construct(SettingsService $settings) {
    	$this->settings = $settings;
    }

    public function index() {
    	$settings = [];
    	$settings['services_counter'] = AppSettings::get('services_counter');
        $settings['vat_tax'] = AppSettings::get('vat_tax');
        $data['settings'] = $settings;
        $data['page'] = 'settings';
        return view('admin.settings', $data);
    }

    public function saveSettings(Request $request) {
        $request_array = $request->all();
        $response = $this->settings->saveSettings($request_array);
        if ($response) {
            return redirect('admin/settings')->with('message', 'Settings updated!');
        } else {
            return redirect('admin/settings')->with('message', 'Settings updation failed!');
        }
    }

}