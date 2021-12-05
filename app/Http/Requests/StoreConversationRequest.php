<?php

namespace App\Http\Requests;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\Pure;
use OpenApi\Annotations as OA;

/**
 * @todo retrieve users by emails OR ids
 * @property-read int[] $users User identifiers.
 * @property-read string|null $title
 * @method User user($guard = null)
 *
 * @OA\Schema(
 *     @OA\Property(property="users", type="array", @OA\Items(type="integer"), description="User identifiers"),
 *     @OA\Property(property="title", type="string"),
 * )
 */
class StoreConversationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('initiate', [Conversation::class, $this->users]);
    }

    #[Pure] public function rules(): array
    {
        return [
            'users' => $this->getUsersRules(),
            'users.*' => $this->getUserIdentifiersRules(),
            'title' => $this->getTitleRules(),
        ];
    }

    #[Pure] protected function getUsersRules(): array
    {
        return [
            'required',
            'array',
            'min:1',
        ];
    }

    #[Pure] protected function getUserIdentifiersRules(): array
    {
        return [
            'required',
            'integer',
            'distinct',
        ];
    }

    #[Pure] protected function getTitleRules(): array
    {
        return [
            'sometimes',
            'string',
            'min:1',
            'max:255',
        ];
    }
}
