<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubServicesOptFormRequest extends FormRequest {

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
            'sub_service_id' => 'required|integer',
            'option_name' => 'required|string',
            'option_description' => 'string',
            'option_order' => 'required|integer|between:1,50',
            'sub_service_id_ref'=>'required'
        ];
    }

}
