<?php

namespace App\Api\V1\Request;

use Dingo\Api\Http\FormRequest;

class MessageUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|integer|exists:messages,id',
            'message' => 'required|string',
        ];
    }
}