<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOvertimeRequest extends FormRequest
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
            'id_atasan'=>'required',
            'id_staff_hr'=>'required',
            'nama'=>'required',
            'tgl_ovt'=>'required',
            'jam_awal'=>'required',
            'jam_akhir'=>'required',
            'ket'=>'required',
        ];
    }

    public function messages(): array
    {
        return [
            'nip.required'=>'NIP Harus Diisi',
            'nip.numeric'=>'NIP Harus Berupa Angka',
            'nama.required'=>'Nama Harus Diisi',
            'id_atasan.required'=>'Atasan Harus Diisi',
            'id_staff_hr.required'=>'Staff HR Harus Diisi',
            'tgl_ovt.required'=>'Tanggal Overtime Harus Diisi',
            'jam_awal.required'=>'Jam Awal Harus Diisi',
            'jam_akhir.required'=>'Jam Akhir Harus Diisi',
            'ket.required'=>'Keterangan Harus Diisi',
        ];
    }
}