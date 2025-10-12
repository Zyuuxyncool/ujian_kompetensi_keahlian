<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserSaveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route()->parameter('user') ?? '';
        return [
            'name' => 'required',
            'email' => 'required|unique:user,email' . ($id != '' ? (',' . $id) : ''),
            'password' => 'confirmed'
        ];
    }
}
