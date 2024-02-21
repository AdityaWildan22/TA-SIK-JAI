<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKaryawanRequest extends FormRequest
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
            'nip'=>'required|numeric',
            'username'=>'required',
            'nama'=>'required',
            'divisi'=>'required',
            'tempat_lahir'=>'required',
            'tanggal_lahir'=>'required',
            'foto_ttd' => 'mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nip.required'=>'NIP Harus Diisi',
            'nip.numeric'=>'NIP Harus Berupa Angka',
            'username.required'=>'Username Harus Diisi',
            'nama.required'=>'Nama Harus Diisi',
            'divisi.required'=>'Divisi Harus Diisi',
            'tempat_lahir.required'=>'Tempat Lahih Harus Diisi',
            'tanggal_lahir.required'=>'Tanggal Lahir Harus Diisi',
            'foto_ttd.mimes'=>"Foto TTD Harus Menggunakan Format .png, .jpg atau .jpeg",
            'foto_ttd.max'=>"Foto TTD Maksimal 2 Mb",
        ];
    }
}