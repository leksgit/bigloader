<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileCheckStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|exists:file_uploads'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
