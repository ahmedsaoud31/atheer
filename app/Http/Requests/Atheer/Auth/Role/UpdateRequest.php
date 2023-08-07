<?php

namespace App\Http\Requests\Atheer\Auth\Role;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Atheer\Auth\RoleRepository;

class UpdateRequest extends FormRequest
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
            'name' => 'required|unique:roles,name,' . $this->role,
		];
    }

    public function withValidator($validator)
    {
        if(!$validator->fails()){
            $role = (new RoleRepository)->byId($this->role);
            if($role->name == 'Super Admin'){
                $validator->after(function ($validator){
                    $validator->errors()->add('public', __('You can\'t edit (Super Admin) role'));
                });
                $validator->validate();
            }
        }
    }
}
