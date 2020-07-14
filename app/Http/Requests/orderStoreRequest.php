<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class orderStoreRequest extends FormRequest {
    const UNPROCESSABLE_ENTITY = 422;

    public function rules() {
        return [
            'cName' => 'required',
            'orderNo' => 'required|numeric',
            'tel' => 'required|numeric'
          ];
    }
    public function messages()
    {
        return [            
            'cName.required' => 'نام مشتری را وارد نمایید',           
            'orderNo.required' => 'شماره سفارش را وارد نمایید',           
            'orderNo.numeric' => 'شماره سفارش فقط عدد است',           
            'tel.required' => 'تلفن را وارد نمایید'       ,    
            'tel.numeric' => 'تلفن فقط عدد'           
        ];
    }

    protected function failedValidation(Validator $validator) {
        $response = array('errors' => $validator->errors(), 'success' => false);

        throw new HttpResponseException(response()->json($response, self::UNPROCESSABLE_ENTITY));
    }
}