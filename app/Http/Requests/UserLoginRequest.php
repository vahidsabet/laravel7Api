<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserLoginRequest extends FormRequest {
    const UNPROCESSABLE_ENTITY = 422;

    public function rules() {
        return [
            'email' => 'required|email',
            'password' => 'required',
          ];
    }
    public function messages()
    {
        return [            
            'password.required' => 'پسورد را وارد نمایید',            
            'email.required' => 'ایمیل را وارد نمایید',
           
        ];
    }

    protected function failedValidation(Validator $validator) {
        $response = array('errors' => $validator->errors(), 'success' => false);

        throw new HttpResponseException(response()->json($response, self::UNPROCESSABLE_ENTITY));
    }
}