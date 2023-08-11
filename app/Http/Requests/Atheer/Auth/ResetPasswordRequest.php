<?php

namespace App\Http\Requests\Atheer\Auth;

use Illuminate\Foundation\Http\FormRequest;

use App\Repositories\UserRepository;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user' => 'required|exists:users,id',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function withValidator($validator)
    {
        $user = (new UserRepository)->byId($this->user);
        if(!$user){
            $validator->after(function ($validator){
                $validator->errors()->add('public', __('User not found'));
            });
        }
        if(!request()->hasValidSignature()){
            $validator->after(function ($validator){
                $validator->errors()->add('public', __('Signature not vaild'));
            });
        }
        $validator->validate();
    }
}