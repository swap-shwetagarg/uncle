<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CarTrimFormRequest extends FormRequest {

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
            'car_model_id' => 'required|integer|unique_with:car_trim,car_trim_name',
            'car_trim_name' => 'required|string',
        ];
    }

}
