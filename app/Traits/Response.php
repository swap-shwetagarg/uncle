<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Traits;

/**
 * Description of Response
 *
 * @author vishal
 */
trait Response {
    
    protected $statusCodeFailed = 500; 
    protected $notFoundCode = 404;
    protected $badRequest = 400;
    protected $statusCodeSuccess = 200;
    protected $failedStatusTxt = 'failed';
    protected $successStatusTxt = 'success';
    protected $badRequestMsg = 'May be bad Request please check befor requesting..';
    protected $failedMessage = 'Not Found';
    protected $cantDelete = 'Can not delete this data';
    protected $duplicate = 'Inserting duplicate or wrong data..Just recheck';
    protected $inserted = ' is added Successfully';
    protected $updated = ' is updated Successfully';
    protected $deleted = ' is deleted Successfully';
    protected $status;
    protected $message;
    protected $code;
    protected $data;
    protected $fetched = 'Fetched Successfully';
    protected $null = [];

    public function getResponse( $status, $message = null, $data = null,$code = null ) {
        $this->setData($status, $message, $data, $code);
        return response()->json($this->getArray(),isset($this->code)?$this->code:$this->getStatusCode($this->status));
    }
    
    public function setData($status, $message = null, $data = null, $code = null) {
        $this->status = $status;
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }
    
    public function getArray() {
        return $this->getResponseArray();
    }
    
    public function getResponseArray() {
        return [
            'status' => $this->getStatus(),
            $this->getStatusBody()  => $this->getMessageBody(),
            'data' => $this->data
        ];
    }
    
    public function getStatusBody() {
        return ($this->status === 'success')? 'message' : 'error' ;
    }
    
    public function getMessageBody() {
        if($this->status === 'success')
        {
            return $this->getMessage();
        }
        return  [ 'message' => $this->getMessage() ]  ; 
    }
    
    public function getStatus() {
        if($this->status === 'success')
        {
            return $this->successStatusTxt;
        }
        return $this->failedStatusTxt;
    }
    
    public function getMessage() {
        if($this->status === 'success')
        {
            return isset($this->message)?$this->message:trans('customResponse.successMessage');
        }
        return isset($this->message)?$this->message:trans('customResponse.failedMessage');
    }
    
    public function getStatusCode() {
        if($this->status === 'success')
        {
            return $this->statusCodeSuccess;
        }
        return $this->statusCodeFailed;
    }
}
