<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Description of AppSettingsService
 *
 * @author Mahesh
 */
class AppSettingsService extends BaseService {

    protected static $model = '\App\Models\AppSettings';
    private $instance = null;

    /**
     * save settings or update record
     * @param string  $name   setting name
     * @param string  $value  value
     * @param boolean $active if setting is active
     */
    public function set($name, $value, $active = true) {
        if ($this->has($name)) {
            return $this->update($name, $value, $active);
        }
        $this->create()->save($name, $value, $active);
        return $this->instance;
    }

    /**
     * check if setting exists
     * @param  string  $name setting name
     * @return boolean       true if exists
     */
    public function has($name) {
        try {
            $this->getModelInstance($name);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * returns value of setting
     * @param  string $name    setting name
     * @param  string $default default value if setting don't exists
     * @return mixed          value, default or null
     */
    public function get($name, $default = null) {
        if ($this->has($name)) {
            return $this->instance->value;
        } elseif (!is_null($default)) {
            return $default;
        }
        return null;
    }

    /**
     * update an existing record
     * @param  string  $name   setting name
     * @param  string  $value  value
     * @param  boolean $active if setting is active
     * @return Model
     */
    public function update($name, $value, $active = true) {
        $this->getModelInstance($name);
        $this->save($name, $value, $active);
        return $this->instance;
    }

    /**
     * check if setting is active
     * @param  string  $name setting name
     * @return boolean       true if active
     */
    public function isActive($name) {
        $this->getModelInstance($name);
        return $this->instance->is_active;
    }

    /**
     * set setting to active
     * @param  string $name active
     * @return boolean  true
     */
    public function activate($name) {
        $this->getModelInstance($name);
        $this->instance->is_active = true;
        $this->instance->save();
        return true;
    }

    /**
     * make setting inactive
     * @param  string $name setting name
     * @return boolean       true
     */
    public function deactivate($name) {
        $this->getModelInstance($name);
        $this->instance->is_active = false;
        $this->instance->save();
        return true;
    }

    /**
     * delete settings from record
     * @param  string $name setting name
     * @return boolean       true
     */
    public function delete($name) {
        $this->getModelInstance($name);
        $this->instance->delete();
        return true;
    }

    /**
     * presists data in db
     * @param  string  $name   name
     * @param  string  $value  value
     * @param  boolean $active if setting is active
     * @return self
     */
    private function save($name, $value, $active = true) {
        $this->instance->name = $name;
        $this->instance->value = $value;
        $this->instance->is_active = $active;
        $this->instance->save();
        return $this;
    }

    /**
     * set $this->instance to Junaidnasir\GlobalSettings\Models\GlobalSettingsModel instance
     * @param  string $name settings name
     * @return self
     */
    private function getModelInstance($name = null) {
        try {
            $this->instance = (new static::$model)->where('name', $name)->firstOrFail();
            return $this;
        } catch (ModelNotFoundException $e) {
            return $this->throwException($name);
        }
    }

    /**
     * create new model
     * @return Model
     */
    private function create() {
        $this->instance = new static::$model;
        return $this;
    }

    /**
     * throw exception
     * @param  string $name setting name
     * @return Exception
     */
    private function throwException($name) {
        throw new Exception("Setting not found {$name}", 1);
    }

}
