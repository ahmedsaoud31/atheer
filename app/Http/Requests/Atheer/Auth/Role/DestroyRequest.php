<?php

namespace App\Http\Requests\Atheer\Auth\Role;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Atheer\Auth\RoleRepository;

class DestroyRequest extends FormRequest
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
        return [];
    }

    public function withValidator($validator)
    {
        $role = (new RoleRepository)->byId($this->role);
        if(!$role){
            $validator->after(function ($validator){
                $validator->errors()->add('public', __('Role not found'));
            });
            $validator->validate();
            return;
        }
        if($role->name == 'Super Admin'){
            $validator->after(function ($validator){
                $validator->errors()->add('public', __('You can\'t delete (Super Admin) role'));
            });
            $validator->validate();
        }
    }
}
