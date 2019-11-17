<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => '',
            'icon' => 'max: 60',
            'title' => 'required | min: 3 | max: 60 | unique:roles',
            'slug' => '',
            'scope' => '',
            'description' => ''
        ];
    }
}
