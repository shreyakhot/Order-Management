<?php

namespace App\Http\Requests\Auth;

use App\Traits\ApiResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginTokenRequest extends FormRequest
{
    use ApiResponseHelper;
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
            'token' => 'required|string',
        ];
    }

    // Override the failedValidation method to return custom JSON response with ApiResponseHelper
    protected function failedValidation(Validator $validator)
    {
        $response = $this->apiResponse(
            false,
            $validator->errors()->first(),
            $validator->errors()->toArray(),
            422
        );

        throw new HttpResponseException($response);
    }
}
