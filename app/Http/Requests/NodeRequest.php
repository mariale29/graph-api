<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NodeRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|unique:nodes,id',
            'parent_id' => 'nullable|exists:nodes,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.unique' => 'Este ID ya está en uso.',
            'parent_id.exists' => 'El nodo padre especificado no existe.',
        ];
    }
}