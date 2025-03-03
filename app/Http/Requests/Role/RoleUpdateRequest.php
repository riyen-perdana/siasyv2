<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
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
            'nm_role' => 'required|unique:roles,name,'.$this->id,
            'permission' => 'required|array|min:1',
            // 'permissions.*' => 'exists:permissions,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nm_role.required' => 'Kolom Otorisasi Pengguna Harus Diisi',
            'nm_role.unique' => 'Otorisasi Pengguna Sudah Ada, Isikan Yang Lain',
            'permission.required' => 'Pilihan Perizinan Harus Diisi',
            'permission.min' => 'Minimal 1 Perizinan Harus Dipilih',
            // 'permissions.*.exists' => 'Perizinan Tidak Ditemukan',
        ];
    }
}
