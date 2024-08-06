<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GrammerRequest extends FormRequest
{
    use GeneralTrait;
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'level'=>['required','string'],
            'text'=>['required','string'],
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
