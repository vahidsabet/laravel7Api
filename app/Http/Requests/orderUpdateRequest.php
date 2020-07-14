<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class orderUpdateRequest extends FormRequest {
    const UNPROCESSABLE_ENTITY = 422;

    public function rules() {
        return [
            'orderNo' => 'required'
        
          ];
    }
    public function messages()
    {
        return [            
            'orderNo.required' => 'شماره سفارش را وارد نمایید'           
        ];
    }

    protected function failedValidation(Validator $validator) {
        $response = array('errors' => $validator->errors(), 'success' => false);

        throw new HttpResponseException(response()->json($response, self::UNPROCESSABLE_ENTITY));
    }
}