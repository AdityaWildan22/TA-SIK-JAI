<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartemenRequest extends FormRequest
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
            "nm_dept"=>"required|unique:departemens",
        ];
    }

    public function messages(): array
    {
        return [
            'nm_dept.required'=>'Nama Departemen Harus Diisi',
            'nm_dept.unique'=>'Nama Departemen Sudah Ada',
        ];
    }
}