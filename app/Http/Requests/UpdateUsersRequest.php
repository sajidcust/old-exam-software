<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'reporting_officer_id' => 'required|exists:users,id',
            'designation_id'       => 'required|exists:designations,id',
            'sub_division_id'      => 'required|exists:sub_divisions,id',
            'name'                 => 'required|max:180',
            'father_name'          => 'required|max:180',
            'password'             => 'nullable|min:8',
            'confirm_password'     => 'nullable|same:password|min:8',
            'address'              => 'nullable|max:200',
            'image'                => 'nullable|mimes:jpeg,jpg,png',
            'signature'            => 'nullable|mimes:jpeg,jpg,png',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
