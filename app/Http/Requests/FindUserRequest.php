<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\Pure;
use OpenApi\Annotations as OA;

/**
 * @property-read string $q
 * @method User user($guard = null)
 *
 * @OA\Schema(
 *     @OA\Property(property="q", type="string", description="Searched value"),
 * )
 */
class FindUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    #[Pure] public function rules(): array
    {
        return [
            'q' => $this->getQueryRiles(),
        ];
    }

    #[Pure] protected function getQueryRiles(): array
    {
        return [
            'required',
            'min:1',
        ];
    }
}
