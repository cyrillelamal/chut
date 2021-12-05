<?php

namespace App\Http\Requests;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\Pure;
use OpenApi\Annotations as OA;

/**
 * @property-read string $title
 * @property-read Conversation $conversation
 * @method User user($guard = null)
 *
 * @OA\Schema(
 *     @OA\Property(property="title", type="string", description="Conversation title"),
 * )
 */
class UpdateConversationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->conversation);
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
