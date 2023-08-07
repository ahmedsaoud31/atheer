<?php

namespace App\Http\Requests\Atheer\Auth\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Repositories\UserRepository;

class UpdateRoleRequest extends FormRequest
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
            'id' => 'required|exists:users',
            'roles' => 'sometimes|array',
            'roles.*' => 'exists:roles,id',
		];
    }

    public function withValidator($validator)
    {
        $user = (new UserRepository)->byId($this->id);
        if(
            $user->id == 1 && !isset($this->roles)
            ||
            $user->id == 1 && isset($this->roles) && !in_array(1, $this->roles)
        ){
            $validator->after(function ($validator){
                $validator->errors()->add('public', __('You can\'t Detach (Super Admin) role from default user'));
            });
            $validator->validate();
            return;
        }
    }
}
