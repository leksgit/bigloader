<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'file|required'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
