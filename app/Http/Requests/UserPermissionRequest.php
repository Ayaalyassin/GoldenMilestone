<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserPermissionRequest extends FormRequest
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
            'name_permission'=>'string|required',
        ];
    }

    public function messages()
    {
        return [

        ];
    }

    public function failedValidation(Validator $validator)

    {
        throw new HttpResponseException($this->returnValidationError('E001',$validator));

    }
}
