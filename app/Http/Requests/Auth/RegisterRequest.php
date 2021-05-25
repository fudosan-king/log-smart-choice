<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email'                 => 'required| string| email| max:100| unique:customers',
            'password'              => ['required', 'string', ' min:8', 'confirmed', 'regex:/^(?=.*[A-Z]|[a-z])(?=.*\d).+$/'],
            'password_confirmation' => 'required|string|min:8',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'email.required'     => __('auth.email_required'),
            'email.max'          => __('auth.email_max_length'),
            'email.email'        => __('auth.email_invalid'),
            'email.unique'       => __('auth.email_already_exist'),
            'password.required'  => __('auth.password_required'),
            'password.min'       => __('auth.pass_word_min_length_include_alphabet'),
            'password.regex'     => __('auth.pass_word_min_length_include_alphabet'),
            'password.confirmed' => 'Password không giống nhau',
        ];
    }
}
