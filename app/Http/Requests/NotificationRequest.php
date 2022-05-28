<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'     => ['required', 'string'],
            'body'      => ['required', 'string'],
            'data'      => ['nullable', 'json'],
            'notification_type' => ['required', Rule::in([1, 2])],
            'user_id'   => [Rule::requiredIf($this->notification_type == 1), 'exists:users,id'],
            'channel_id'   => [Rule::requiredIf($this->notification_type == 2), 'exists:channels,id']
        ];
    }
}
