<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\Pure;

/**
 * @property-read string $email
 * @property-read string $password
 * @property-read string $device_name
 */
class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guest();
    }

    #[Pure] public function rules(): array
    {
        return [
            'email' => $this->getEmailRules(),
            'password' => $this->getPasswordRules(),
            'device_name' => $this->getDeviceNameRules(),
        ];
    }

    #[Pure] protected function getEmailRules(): array
    {
        return [
            'required',
            'email',
        ];
    }

    #[Pure] protected function getPasswordRules(): array
    {
        return [
            'required',
        ];
    }

    #[Pure] protected function getDeviceNameRules(): array
    {
        return [
            'required',
        ];
    }
}
