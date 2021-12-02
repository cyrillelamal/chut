<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\Pure;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     @OA\Property(property="users", type="array", @OA\Items(type="integer"), description="User identifiers"),
 *     @OA\Property(property="title", type="string"),
 * )
 */
class StoreConversationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    #[Pure] public function rules(): array
    {
        return [
            'users' => $this->getUsersRules(),
            'users.*' => $this->getUserIdentifiersRules(),
            'title' => $this->getTitleRules(),
        ];
    }

    #[Pure] public function getUsersRules(): array
    {
        return [
            'required',
            'array',
            'min:1',
        ];
    }

    #[Pure] public function getUserIdentifiersRules(): array
    {
        return [
            'required',
            'integer',
            'distinct',
        ];
    }

    #[Pure] public function getTitleRules(): array
    {
        return [
            'sometimes',
            'string',
            'min:1',
            'max:255',
        ];
    }
}
