<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        app()->setLocale('es');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'postal_code' => ['required', 'string', 'max:10'],
            'province' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'max:100'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.max' => 'El teléfono no puede tener más de 20 caracteres.',
            'address.required' => 'La dirección es obligatoria.',
            'address.max' => 'La dirección no puede tener más de 255 caracteres.',
            'city.required' => 'La ciudad es obligatoria.',
            'city.max' => 'La ciudad no puede tener más de 100 caracteres.',
            'postal_code.required' => 'El código postal es obligatorio.',
            'postal_code.max' => 'El código postal no puede tener más de 10 caracteres.',
            'province.required' => 'La provincia es obligatoria.',
            'province.max' => 'La provincia no puede tener más de 100 caracteres.',
            'country.required' => 'El país es obligatorio.',
            'country.max' => 'El país no puede tener más de 100 caracteres.',
        ];
    }
}
