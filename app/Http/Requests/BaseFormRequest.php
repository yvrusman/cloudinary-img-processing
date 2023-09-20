<?php

namespace App\Http\Requests;

use App\Exceptions\ActionNotAllowedException;
use App\Utils\CustomError;
use App\Utils\JsonApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BaseFormRequest extends FormRequest
{
    /**
     * This overrides the default throwable failed message in JSON format
     * 
     * @param Validator $validator
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = JsonApiResponse::ofClientError("Client-side validation error", $validator->errors()->all());
        throw new ValidationException($validator, $response);
    }

    /**
     * This overrides the default throwable Authorization Exception
     * 
     * @throws ActionNotAllowedException
     */
    protected function failedAuthorization()
    {
        throw new ActionNotAllowedException();
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Set custom error messages for user requests
     */
    public function messages(): array
    {
        return CustomError::customErrorMessages();
    }
}
