<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
			'name' => 'required|string|max:50',
			'username' => 'required|string|max:20|unique:users,username,' . $this->user()->id,
			'email' => 'required|string|email|max:50|unique:users,email,' . $this->user()->id,
			'staff' => 'nullable|string|max:50',
			'password' => 'nullable|string|min:5|confirmed',
		];

		if ($this->hasFile('image')) {
			$rules['image'] = 'image|mimes:jpeg,png,jpg|max:2048';
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
			'name.required' => 'Nama wajib diisi.',
			'username.required' => 'Username wajib diisi.',
			'username.unique' => 'Username sudah digunakan.',
			'email.required' => 'Email wajib diisi.',
			'email.unique' => 'Email sudah digunakan.',
			'image.mimes' => 'Format gambar harus berupa JPG, PNG, atau JPEG.',
			'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
			'password.min' => 'Password harus memiliki minimal 8 karakter.',
			'password.confirmed' => 'Password tidak cocok.',
		];
	}
}
