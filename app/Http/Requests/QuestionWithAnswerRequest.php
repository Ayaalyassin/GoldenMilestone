<?php

namespace App\Http\Requests;

use App\Traits\GeneralTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class QuestionWithAnswerRequest extends FormRequest
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
            'answers'=>  'required|array',
            'answers.*.text'=>'string|required',
            'answers.*.status'=>'boolean|required',
        ];
    }

    public function messages()
    {
        return [
           'text.required' => 'text is required.',
            'text.string' => 'text is String.',
        ];
    }

    public function failedValidation(Validator $validator)

    {
        throw new HttpResponseException($this->returnValidationError('E001',$validator));

    }
}
