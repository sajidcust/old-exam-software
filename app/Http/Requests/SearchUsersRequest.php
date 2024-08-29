<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchUsersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search'          => 'nullable',
            'sub_division_id' => 'nullable|exists:sub_divisions,id',
            'designation_id'  => 'nullable|exists:designations,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
