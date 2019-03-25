<?php

namespace App\Facades;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Support\Facades\Facade;

/**
 * Description of AppSettings
 *
 * @author Mahesh
 */
class AppSettings extends Facade {

    protected static function getFacadeAccessor() {
        return 'appSettings';
    }

}
