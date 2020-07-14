<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserChPasswordRequest extends FormRequest {
    const UNPROCESSABLE_ENTITY = 422;

    public function rules() {
        return [
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
          ];
    }
    public function messages()
    {
        return [
            'old_password.required' => 'پسورد قبلی را وارد نمایید',
            'new_password.required' => 'پسورد را وارد نمایید',
            'confirm_password.required' => 'پسورد مجدد را وارد نمایید',
            'confirm_password.same' => 'پسورد یکسان نیست',          
            'new_password.min' => 'حداقل 8 کاراکتر نیاز است',           
            'old_password.min' => 'حداقل 8 کاراکتر نیاز است',           
        ];
    }

    protected function failedValidation(Validator $validator) {
        $response = array('errors' => $validator->errors(), 'success' => false);
        throw new HttpResponseException(response()->json($response, 422));
        //return response()->json($response, 401);
    }
}