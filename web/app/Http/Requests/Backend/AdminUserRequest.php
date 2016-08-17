<?php

namespace App\Http\Requests\Backend;

use App\Http\Requests\Request;

class AdminUserRequest extends Request
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
        $password = 'required|confirmed|min:6';
        if($this->id) {
            $password = 'confirmed|min:6';
        }
        return [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$this->id,
            'password' => $password
        ];
    }
}
