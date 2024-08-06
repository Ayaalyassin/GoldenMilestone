<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RolePermissionRequest extends FormRequest
{
    use GeneralTrait;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name_role'=>'string|required',
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
