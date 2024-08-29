<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationFormRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'name'     => 'required|max:300',
			'email'    => 'required|max:30|unique:users,email',
			'password' => 'required|min:8',

		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
