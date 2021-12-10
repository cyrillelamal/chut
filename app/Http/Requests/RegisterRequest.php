<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\Pure;

/**
 * @property-read string $email
 * @property-read string $password
 * @property-read string $name
 * @OA\Schema(
 *     @OA\Property(property="email", type="string", format="email"),
 *     @OA\Property(property="password", type="string"),
 *     @OA\Property(property="name", type="string", description="User's name"),
 * )
 */
class RegisterRequest extends FormRequest
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
            'name' => $this->getNameRules(),
        ];
    }

    #[Pure] protected function getEmailRules(): array
    {
        return [
            'required',
            'email',
            'unique:users,email',
        ];
    }

    #[Pure] protected function getPasswordRules(): array
    {
        return [
            'required',
            'min:6',
            'max:191',
        ];
    }

    #[Pure] protected function getNameRules(): array
    {
        return [
            'required',
        ];
    }
}
