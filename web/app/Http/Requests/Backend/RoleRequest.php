<?php

namespace App\Http\Requests\Backend;

use App\Models\Permission;
use App\Http\Requests\Request;

class RoleRequest extends Request
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
        $permissions = Permission::lists('id')->toArray();
        $permissions = implode(',', $permissions);

        return [
            'name' => 'required|unique:roles,name,'.$this->id,
            'permissions' => 'required'
        ];
    }
}
