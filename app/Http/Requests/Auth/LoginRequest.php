<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'email'    => ['required','email','string'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z|A-Z])(?=.*[a-zA-Z])(?=.*\d).+$/'],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'email.required'    => __('auth.email_required'),
            'email.max'         => __('auth.email_max_length'),
            'email.email'       => __('auth.email_invalid'),
            'password.required' => __('auth.password_required'),
            'password.min'      => __('auth.pass_word_min_length_include_alphabet'),
            'password.regex'    => __('auth.pass_word_min_length_include_alphabet'),
        ];
    }
}
