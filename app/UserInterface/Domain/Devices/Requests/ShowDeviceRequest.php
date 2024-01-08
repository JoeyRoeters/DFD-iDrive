<?php

namespace App\UserInterface\Domain\Devices\Requests;

use App\Domain\Device\Model\Device;
use Illuminate\Foundation\Http\FormRequest;

class ShowDeviceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): \Illuminate\Http\RedirectResponse|bool
    {
        $id = $this->route('id');
        $device = Device::where('_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($device == null) {
            return redirect()->route('devices.overview');
        }

        return false;
    }


    protected function failedAuthorization()
    {
        // Voeg hier eventuele aangepaste logica toe bij mislukte autorisatie
        abort(403, 'Aangepaste foutmelding bij mislukte autorisatie');
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:devices,id',
        ];
    }
}
