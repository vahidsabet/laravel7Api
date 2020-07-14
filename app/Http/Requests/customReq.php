<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator; 
use Illuminate\Http\Exceptions\HttpResponseException;

class customReq extends FormRequest
{
    const UNPROCESSABLE_ENTITY = 422;
    public function messages()
    {
        return [
            'name.required' => 'نام را وارد نمایید',
            'password.required' => 'پسورد را وارد نمایید',
            'email.required' => 'ایمیل را وارد نمایید',
            'email.email' => 'ایمیل معتبر وارد نمایید',
            'password.min' => 'حداقل 8 کاراکتر پسورد نیاز است',
            'email.unique' => 'ایمیل قبلا استفاده شده است',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        
        $response = array('errors' => $validator->errors(), 'success' => false);
        throw new HttpResponseException(response()->json($response, self::UNPROCESSABLE_ENTITY));
    /*    $response = new JsonResponse(['data' => [], 
                'meta' => [
                    'message' => 'The given data is invalid', 
                    'errors' => $validator->errors()
                ]], 422);

        throw new ValidationException($validator, $response);*/
    }

}
