<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class orderStateRequest extends FormRequest {
    const UNPROCESSABLE_ENTITY = 422;

    public function rules() {
        return [
            'orderNo' => 'required',
            'tel' => 'required',
          ];
    }
    public function messages()
    {
        return [            
            'orderNo.required' => 'شماره سفارش را وارد نمایید',            
            'tel.required' => 'تلفن را وارد نمایید',
           
        ];
    }

    protected function failedValidation(Validator $validator) {
        $response = array('errors' => $validator->errors(), 'success' => false);

        throw new HttpResponseException(response()->json($response, self::UNPROCESSABLE_ENTITY));
    }
}