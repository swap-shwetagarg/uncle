<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModelFormRequest extends FormRequest {

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
            'year_id' => 'required|integer|unique_with:car_models,modal_name',
            'modal_name' => 'required|string',
            'car_id' => 'sometimes|required',
        ];
    }

}
