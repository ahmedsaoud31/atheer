<?php

namespace App\Http\Requests\Atheer\Auth\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Repositories\Atheer\Auth\RoleRepository;

class UpdatePermissionRequest extends FormRequest
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
            'id' => 'required|exists:roles',
            'permissions' => 'sometimes|array',
            'permissions.*' => 'exists:permissions,id',
		];
    }

    public function withValidator($validator)
    {
        $role = (new RoleRepository)->byId($this->id);
        if($role->name == 'Super Admin'){
            $validator->after(function ($validator){
                $validator->errors()->add('public', __('(Super Admin) role don\'t need to attach any permission'));
            });
            $validator->validate();
            return;
        }
    }
}
