<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    protected $roles = ['admin', 'user'];
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
        return [
            'avatar' => 'required|dimensions:max_width=256,max_height=256',
            'username' => 'min:4|max:20',
            'user_role' => [
                Rule::in($this->roles)
            ],
            'registered_at' => 'required|date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return [
            'avatar.dimensions' => 'Correct Dimensions are 256 * 256.'
        ];
    }
}
