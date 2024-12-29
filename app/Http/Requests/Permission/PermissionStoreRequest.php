<?php

namespace App\Http\Requests\Permission;

use Illuminate\Foundation\Http\FormRequest;

class PermissionStoreRequest extends FormRequest
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
            'nm_perizinan' => 'required|unique:permissions,name',
        ];
    }

    public function messages(): array
    {
        return [
            'nm_perizinan.required' => 'Kolom Nama Perizinan Harus Diisi',
            'nm_perizinan.unique' => 'Perizinan Sudah Ada, Isikan Yang Lain',
        ];
    }
}
