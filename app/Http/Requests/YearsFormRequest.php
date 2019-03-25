<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class YearsFormRequest extends FormRequest {

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
            'year' => 'required|integer|unique_with:years,car_id',
            'car_id' => 'required',
        ];
    }

}
