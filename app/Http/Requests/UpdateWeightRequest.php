<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWeightRequest extends FormRequest
{
    public function rules()
    {
        return [
            'weight' => 'required|numeric|min:0|max:100'
        ];
    }
}
