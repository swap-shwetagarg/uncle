<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AppSettingsService;
use App\Models\AppSettings;

class AppSettingController extends Controller
{
    protected $appSetting;
    public function __construct(AppSettingsService $appSetting) {
        $this->appSetting = $appSetting;
    }
    
    public function index()
    {
        dd(AppSettings::all());
        return view('errors.g');
    }
    
    public function store(Request $request)
    {
        $result = $this->appSetting->set($request->name,$request->value);
        return response()->json(['status' => 'success']);
    }
    
    public function show($id)
    {
        $result = $this->appSetting->get($request->name);
        if(!isEmpty($result))
        {
            return response()->json(['status' => 'success','value' => $result]);
        }
    } 
    
    public function update(Request $request,$id)
    {
        $result = $this->appSetting->update($request->name);
        if(!isEmpty($result))
        {
            return response()->json(['status' => 'success','value' => $result]);
        }
    }        
}
