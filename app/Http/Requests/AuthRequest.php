<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
{
    use GeneralTrait;
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'=>'required|string',
            //'email'=>'required|string|email|unique:users',
            'phone_number'=>['required','regex:/^(?:\+88|09)?(?:\d{10}|\d{13})$/','unique:users'],
            'password' => 'required|min:8|max:32',

        ];
    }

    public function messages(): array
    {
        return [

        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->returnValidationError('E001',$validator));

    }
}
