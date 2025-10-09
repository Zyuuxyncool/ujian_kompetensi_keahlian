<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $params = [
            'nama' => 'required|min:4',
            'notelp' => 'required|min:9',
//            'nik' => 'required|digits:16|unique:masyarakat',
            'email' => 'required|unique:user',
            'password' => 'required|confirmed|min:4'
        ];

        $role = $this->input('role') ?? '';
        if ($role == 'Masyarakat') $params['nik'] = 'required|min:16|max:16|unique:masyarakat';

        return $params;
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama tidak boleh kosong',
            'nama.min' => 'Nama minimal 4 karakter',
            'notelp.required' => 'No. Telepon tidak boleh kosong',
            'notelp.min' => 'No. Telepon minimal 9 karakter',
            'email.required' => 'Email tidak boleh kosong, silahkan pakai lupa password dibawah ini',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 4 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sama',
            'nik.required' => 'NIK tidak boleh kosong',
            'nik.unique' => 'NIK sudah terdaftar, silahkan pakai lupa password dibawah ini',
            'nik.digits' => 'NIK harus 16 karakter'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'nama' => trim(strip_tags($this->input('nama'))),
            'email' => filter_var(strtolower($this->input('email')), FILTER_SANITIZE_EMAIL),
            'nik.unique' => 'NIK sudah terdaftar'
        ]);
    }
}
