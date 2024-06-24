<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    use GeneralTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'phone_number'=>['required','regex:/^(?:\+88|09)?(?:\d{10}|\d{13})$/'],
            'email' => 'nullable|email',
            //'phone_number'=>'required',
            'password' => 'required|min:8|max:32',
        ];
    }

    public function messages()
    {
        return [
            /*'email.required' => 'Email is required.',
            'email.email' => 'Enter a valid email address.',
            'password.required' => 'Password is required.',
            'name.required'=>'Name is required.'*/
        ];
    }


    public function failedValidation(Validator $validator)

    {
        throw new HttpResponseException($this->returnValidationError('E001',$validator));

    }
}
