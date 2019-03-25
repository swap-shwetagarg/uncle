<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserProfileRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required',
            'email' => 'sometimes|required|email',
            'mobile' => 'sometimes|required|digits:10|regex:/^(\+\d{1,3}[- ]?)?\d{10}$/',
            'zip_code' => 'integer',
            'address' => 'string'
        ];
    }

}
