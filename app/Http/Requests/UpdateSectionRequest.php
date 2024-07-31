<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionRequest extends FormRequest
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
            "id_departemen"=>'required',
            'nm_section'=>'required',
        ];
    }

    public function messages(): array
    {
        return [
            'id_departemen.required'=>'Departemen Harus Dipilih',
            'nm_section.required'=>'Section Harus Diisi',
        ];
    }
}
