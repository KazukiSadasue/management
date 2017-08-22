<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class SampleRequest extends Request
{
    /**
    * Determine if the user is authorized to make this request.$_COOKIE
    * 
    * @return bool
    */
    public function authorize()
    {
        return true;
    }

    /**
    * Get the validation rules that apply to the request.$_COOKIE
    *
    *@return array
    */
    public function rules()
    {
        return[
            'test' => "required|testStringCheck"
        ];
    }

    public function messages()
    {
        return [
            'test.test_string_check' =>'testという文字列が入ってません。'
        ];
    }
}