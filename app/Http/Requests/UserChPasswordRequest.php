<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserChPasswordRequest extends FormRequest {
    const UNPROCESSABLE_ENTITY = 422;

    public function rules() {
        return [
            'old_password' => 'required',
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
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), self::UNPROCESSABLE_ENTITY));
    }
}