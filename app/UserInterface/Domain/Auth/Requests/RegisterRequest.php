<?php

namespace App\UserInterface\Domain\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email',
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
                'confirmed',
            ],
            'terms' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Het wachtwoord moet minimaal 8 tekens lang zijn en ten minste één kleine letter, één hoofdletter, één cijfer en één speciaal teken bevatten.',
        ];
    }


}
