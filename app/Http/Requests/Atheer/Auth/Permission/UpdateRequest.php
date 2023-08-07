<?php

namespace App\Http\Requests\Atheer\Auth\Permission;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Atheer\Auth\PermissionRepository;

use Atheer;

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
            'name' => 'required|unique:permissions,name,' . $this->permission,
		];
    }


    public function withValidator($validator)
    {
        if(!$validator->fails()){
            $permission = (new PermissionRepository)->byId($this->permission);
            if(Atheer::isAtheerPermission($permission->name)){
                $validator->after(function ($validator){
                    $validator->errors()->add('public', __('You can\'t edit atheer permissions'));
                });
                $validator->validate();
            }
        }
    }
}
