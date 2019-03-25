<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubServicesFormRequest extends FormRequest {

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
            'service_id' => 'required|integer|unique_with:sub_services,title',
            'title' => 'required|string',
            'description' => 'string',
            'order' => 'required|integer|between:1,50',
            'selection_type' => 'required|string|in:M,O'
        ];
    }

}
