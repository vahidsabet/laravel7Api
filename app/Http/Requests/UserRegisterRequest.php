<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRegisterRequest extends FormRequest {
    const UNPROCESSABLE_ENTITY = 422;

    public function rules() {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
          ];
    }
    public function messages()
    {
        return [
            'name.required' => 'نام را وارد نمایید',
            'password.required' => 'پسورد را وارد نمایید',
            'password_c.required' => 'پسورد مجدد را وارد نمایید',
            'password_c.same' => 'پسورد یکسان نیست',
            'email.required' => 'ایمیل را وارد نمایید',
            'password.min' => 'حداقل 8 کاراکتر نیاز است',
            'email.unique' => 'ایمیل قبلا استفاده شده است',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), self::UNPROCESSABLE_ENTITY));
    }
}