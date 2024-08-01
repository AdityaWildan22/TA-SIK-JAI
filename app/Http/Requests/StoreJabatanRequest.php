<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJabatanRequest extends FormRequest
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
            "nm_jabatan"=>"required|unique:jabatans"
        ];
    }

    public function messages(): array
    {
        return [
            'nm_jabatan.required'=>'Nama Jabatan Harus Diisi',
            'nm_jabatan.unique'=>'Nama Jabatan Sudah Ada',
        ];
    }
}