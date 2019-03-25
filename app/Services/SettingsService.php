<?php


namespace App\Services;

use App\Repositories\Settings\SettingsInterface;

class SettingsService extends BaseService{

    protected $settingsInterface;

    public function __construct(SettingsInterface $settingsInterface) {
        $this->settingsInterface = $settingsInterface;
    }
    
    public function saveSettings($request_array) {
        return $this->settingsInterface->saveSettings($request_array);
    }
}
