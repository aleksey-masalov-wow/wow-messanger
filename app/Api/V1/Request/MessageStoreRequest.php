<?php

namespace App\Api\V1\Request;

use Dingo\Api\Http\FormRequest;

class MessageStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sender_id' => 'required|integer|exists:users,id',
            'channel' => 'required|string|max:150',
            'message' => 'required|string',
        ];
    }
}