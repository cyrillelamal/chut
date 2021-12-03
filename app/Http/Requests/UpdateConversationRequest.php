<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\Pure;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     @OA\Property(property="title", type="string", description="Conversation title"),
 * )
 */
class UpdateConversationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    #[Pure] public function rules(): array
    {
        return [
            'title' => $this->getTitleRules(),
        ];
    }

    #[Pure] protected function getTitleRules(): array
    {
        return [
            'required',
            'string',
            'min:1',
            'max:255',
        ];
    }
}
