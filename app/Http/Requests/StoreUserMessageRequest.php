<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\Pure;

/**
 * @property-read User $receiver
 * @method User user($guard = null)
 */
class StoreUserMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('send-private-message-to', $this->receiver);
    }

    #[Pure] public function rules(): array
    {
        return [
            'body' => $this->getBodyRules(),
        ];
    }

    #[Pure] protected function getBodyRules(): array
    {
        return [
            'required',
            'string',
            'min:1',
        ];
    }
}
