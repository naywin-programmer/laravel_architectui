<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategory extends FormRequest
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
            'name_my' => 'required',
            'name_en' => 'required',
            'link' => 'nullable|unique:catgories'
        ];
    }

    public function messages()
    {
        return [
            'name_my.required' => 'Name (Burmese) is required.',
            'name_en.required' => 'Name (English) is required.'
        ];
    }
}
