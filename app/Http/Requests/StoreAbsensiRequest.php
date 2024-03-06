<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAbsensiRequest extends FormRequest
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
            'nama'=>'required',
            'tgl_absen'=>'required',
            'jns_absen'=>'required',
            'ket'=>'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nip.required'=>'NIP Harus Diisi',
            'nip.numeric'=>'NIP Harus Berupa Angka',
            'nama.required'=>'Nama Harus Diisi',
            'tgl_absen.required'=>'Tanggal Absen Harus Diisi',
            'jns_absen.required'=>'Jenis Absen Harus Diisi',
            'ket.required'=>'Keterangan Harus Diisi',
        ];
    }
}