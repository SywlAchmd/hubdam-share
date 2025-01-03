<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'identifier' => 'required|string',
            'password' => 'required'
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $credentials = ['password' => $this->password];

        // Check if the identifier is an email or username
        if (filter_var($this->identifier, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $this->identifier;
        } else {
            $credentials['username'] = $this->identifier;
        }

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'identifier' => 'Email atau username, atau password anda salah!',
            ]);
        }
    }

    /**
     * Get the validation error messages that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            'identifier.required' => 'Masukan email atau username anda!',
            'password.required' => 'Masukan password anda!'
        ];
    }
}
