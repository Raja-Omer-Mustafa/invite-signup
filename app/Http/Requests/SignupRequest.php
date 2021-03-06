<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [ // can define separate request for signup rules
            'username' => [
                'required',
                'string',
                'min:4',
                'max:20',
                'unique:users,name',
                'alpha_dash',
            ],
            'password' => [
                'required', 
                'string',
                'min:8',
                'confirmed'
            ],
            'token' => [
                'exists:invites'
            ]
        ];
    }
}
