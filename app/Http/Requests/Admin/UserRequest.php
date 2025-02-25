<?php

namespace App\Http\Requests\Admin;

use App\Models\User;
use App\Traits\ApiResponseHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Route;

class UserRequest extends FormRequest
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
        $userId = Route::current()->parameter('user');
        if ($this->method() === 'POST') {
            // Rules for the create request
            return [
                'name' => 'required|max:255',
                'username' => 'required|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'phone' => 'required|unique:users,phone',
                'password' => 'required|min:8',
                'image' => 'sometimes|image',
                'roles' => 'nullable|array',
                'roles.*' => 'in:admin,customer,user',
            ];
        } elseif ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            // Rules for the update request if rules change from create request
            return [
                'name' => 'required|max:255',
                'username' => ['required', 'max:255', Rule::unique('users')->ignore($this->user)],
                'email' => ['sometimes', 'email', 'max:255', Rule::unique('users')->ignore($this->user)],
                'phone' => ['sometimes', Rule::unique('users', 'phone')->ignore($this->user)],
                'password' => 'nullable|min:8',
                'image' => 'sometimes|image',
                'roles' => 'sometimes|array',
                'roles.*' => 'in:admin,customer,user',
            ];
        }

        return [];
    }

    /*protected function prepareForValidation()
    {
        // Retrieve the user ID from the route parameter
        $userId = $this->route('user');

        // Fetch the user instance from the database
        $this->user = User::find($userId);

        // Add the user instance to the validation data
        $this->merge(['user' => $this->user]);
    }*/

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
