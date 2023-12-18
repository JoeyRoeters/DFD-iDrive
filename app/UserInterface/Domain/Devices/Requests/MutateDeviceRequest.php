<?php

namespace App\UserInterface\Domain\Devices\Requests;

use App\Domain\Device\Model\TypeEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MutateDeviceRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'devicename' => 'required',
            'devicetype' => Rule::in(['comma','sim']),
            ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'devicename' => 'The name is required',
            'devicetype' => 'The type is required',
        ];
    }


}
