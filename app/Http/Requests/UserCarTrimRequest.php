<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCarTrimRequest extends FormRequest {

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
            'car_id' => 'required|integer',
            'year_id' => 'required|integer',
            'car_model_id' => 'required|integer',
            'car_trim_id' => 'required|integer'
        ];
    }

}
