<?php

namespace App\Http\Requests\Atheer\Auth\Permission;

use Illuminate\Foundation\Http\FormRequest;
use App\Repositories\Atheer\Auth\PermissionRepository;

use Atheer;

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
        $permission = (new PermissionRepository)->byId($this->permission);
        if(!$permission){
            $validator->after(function ($validator){
                $validator->errors()->add('public', __('Permission not found'));
            });
            $validator->validate();
            return;
        }
        if(Atheer::isAtheerPermission($permission->name)){
            $validator->after(function ($validator){
                $validator->errors()->add('public', __('You can\'t delete atheer permissions'));
            });
            $validator->validate();
            return;
        }
    }
}
