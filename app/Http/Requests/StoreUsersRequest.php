<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
{
	public function rules(): array
	{
		return [
			'name'             => 'required|max:300',
			'email_address'    => 'required|max:30|unique:users,email',
			'password'         => 'required|min:8',
			'confirm_password' => 'required|same:password|min:8',
			//			'status'           => 'required',

		];
	}

	public function authorize(): bool
	{
		return true;
	}
}
