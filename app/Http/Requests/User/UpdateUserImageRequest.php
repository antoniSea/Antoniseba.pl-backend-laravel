<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserImageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Prosimy wybrać plik.',
            'file.image' => 'Plik musi być obrazem.',
            'file.mimes' => 'Plik musi być obrazem.',
            'file.max' => 'Rozmiar pliku nie może przekraczać 2MB.',
        ];
    }
}
