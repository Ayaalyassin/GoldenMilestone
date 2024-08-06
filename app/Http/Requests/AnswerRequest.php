<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AnswerRequest extends FormRequest
{
    use GeneralTrait;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id'=>'sometimes|required',
            'text'=>'string|required',
            'status'=>'boolean|required',
            'question_id'=>'required',
        ];
    }

    public function messages()
    {
        return [
           'text.required' => 'Name is required.',
            'text.string' => 'Name is String.',
            'status.required' => 'Status is required.',
            'status.boolean' => 'Status is Boolean.',
            'question_id.required' => 'question id is required.',
        ];
    }

    public function failedValidation(Validator $validator)

    {
        throw new HttpResponseException($this->returnValidationError('E001',$validator));

    }
}
