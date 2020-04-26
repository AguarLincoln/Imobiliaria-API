<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RealStateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //criar validação
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
            'title' => 'required',
            'price' => 'required',
            'bathrooms' => 'required',
            'bathrooms' => 'required',
            'classification' => 'required',
            'total_area' => 'required',
            'description' => 'required',
            'about'=> 'required'
        ];
    }
}
